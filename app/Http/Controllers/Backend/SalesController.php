<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Transactions\Sales\StoreSalesRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sales;
use App\Models\Transaction;
use App\Services\Transactions\SalesServices;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class SalesController extends Controller
{
    /** @var $salesServices Sales Services */
    protected $salesServices;

    /**
     * SalesController constructor.
     *
     * @param SalesServices $salesServices
     */
    public function __construct(SalesServices $salesServices) {
        $this->salesServices = $salesServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::limit(10)->get();
        $categories = ProductCategory::get();
        $customers = Customer::limit(10)->get();
        return view('backend.sales.create', compact('products', 'customers', 'categories'));
    }

    /**
     * Edit the specified resource.
     *
     * @param  Sales $sales
     */
    public function edit(Sales $sales){


        return view('backend.sales.edit', compact('sales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesRequest $request)
    {
        $lastSale = $this->salesServices->takeLastRow();
        $code = 'INV/' . date('Ymd') . '/' . ($lastSale ? $lastSale->id + 1 : 1);
        DB::beginTransaction();
        try {
            if ($request->selected_customer == 0 || $request->selected_customer == null) {
                $customer = Customer::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ]);
            }else{
                $customer = Customer::find($request->selected_customer);
            }
            $sales = Sales::create([
                'invoice_number' => $code,
                'customer_id' => $customer->id,
                'total' => $request->total,
                'discount' => $request->discounts['price'],
                'remarks' => $request->remarks
            ]);

            foreach ($request->products as $product) {
                $sales->details()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['price'],
                ]);

                $product_model = Product::find($product['product_id']);
                $product_model->update([
                    'quantity' => $product_model->quantity - $product['quantity'],
                ]);
            }

            if ($sales) {
                $sales->transaction()->create([
                    'total' => $sales->grand_total,
                    'status' => Transaction::STATUS_PENDING,
                    'code' => 'P-' . $sales->invoice_number,
                ]);
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating your transaction.'.$e));
        }
        DB::commit();
        return redirect()->route('admin.sales.show', $sales)->withFlashSuccess(__('Sales transaction successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        $sales->with('customer', 'details');
        return view('backend.sales.show', compact('sales'));
    }

    public function print(Request $request, Sales $sales)
    {
        $print = 'invoice';

        if ($request->has('print')) {
            $print = $request->print;
        }

        $sales = $sales->with('customer', 'details', 'transaction')->find($sales->id);
        // dd($sales);
        // dd($sales);
        // return view('backend.utils.print.saless.out', compact('sales'));
        // return view('backend.utils.print.transactions.receipt', compact('sales'));
        // $pdf = Pdf::loadView('backend.utils.print.transactions.receipt', compact('sales'))->setPaper('58mm', 'potrait')->setOptions(['dpi' => 90, 'defaultFont' => 'Source Sans Pro', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf = Pdf::loadView('backend.utils.print.transactions.out', compact('sales'))->setPaper('a5', 'landscape')->setOptions(['dpi' => 90, 'defaultFont' => 'Source Sans Pro', 'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true]);
        return $pdf->stream($print.'.pdf');
    }

    public function storePayment(Request $request, Sales $sales)
    {
        $sales->with('customer', 'details', 'transaction');

        $transaction = $sales->transaction;

        $request->merge(['payment' => clear_number($request->payment)]);
        if ($transaction->hasPayment()) {
            return redirect()->route('admin.sales.index')->withFlashDanger(__('This sales already has payment.'));
        }

        $payment = $transaction->payment()->create([
            'amount' => $request->payment,
            'code' => 'PAY-'.$transaction->code
        ]);

        if ($payment) {
            if ((int)$request->payment == (int)$transaction->total) {
                $transaction->update([
                    'status' => 'paid',
                ]);
            }elseif ((int)$request->payment < (int)$transaction->total) {
                $transaction->update([
                    'status' => 'debt',
                ]);
            }
        }

        return redirect()->route('admin.sales.show', ['sales' => $sales])->withFlashSuccess(__('Payment transaction successfully created.'));
    }

    public function updatePayment(Request $request, Sales $sales)
    {
        $sales->with('customer', 'details', 'transaction');


        $transaction = $sales->transaction;


        $request->merge(['payment' => clear_number($request->payment)]);

        $payment = $transaction->payment()->update([
            'amount' => $request->payment
        ]);

        if ($payment) {
            if ((int)$request->payment == (int)$sales->grand_total) {
                $transaction->update([
                    'status' => 'paid',
                ]);
            }elseif ((int)$request->payment < (int)$sales->grand_total) {
                $transaction->update([
                    'status' => 'debt',
                ]);
            }
        }

        return redirect()->route('admin.sales.show', ['sales' => $sales])->withFlashSuccess(__('Payment transaction successfully created.'));
    }

    public function destroy(Request $request, Sales $sales)
    {
        $sales = $sales->with('details', 'transaction')->find($sales->id);
        $salesDetails = $sales->details;
        $salesTransaction = $sales->transaction;

        DB::beginTransaction();

        $salesTransaction->update([
            'status' => Transaction::STATUS_CANCELED,
        ]);

        try {
            foreach ($salesDetails as $detail) {
                $product = Product::find($detail->product_id);
                $product->update([
                    'quantity' => $product->quantity + $detail->quantity,
                ]);
            }


            if ($salesTransaction->hasPayment()) {
                $salesTransaction->payment->delete();
            }

            $sales->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem deleting your transaction.'.$e));
        }

        DB::commit();
        return redirect()->route('admin.sales.index')->withFlashSuccess(__('Sales transaction successfully deleted.'));
    }
}
