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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesRequest $request)
    {
        // dd($request->all());
        $code = 'INV/' . date('Ymdhis') . '/'. $request->selected_customer .'/' . Uuid::uuid4()->toString();
        DB::beginTransaction();
        try {
            $sales = Sales::create([
                'invoice_number' => $code,
                'customer_id' => $request->selected_customer,
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
                    'total' => $sales->total,
                    'status' => Transaction::STATUS_PENDING,
                    'code' => 'PUR-' . Uuid::uuid4()->toString(),
                ]);
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating your transaction.'.$e));
        }
        DB::commit();
        return redirect()->route('admin.sales.index')->withFlashSuccess(__('Sales transaction successfully created.'));
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

    public function print(Sales $sales)
    {
        $sales = $sales->with('customer', 'details')->find($sales->id);
        // dd($sales);
        // return view('backend.utils.print.saless.out', compact('sales'));
        $pdf = Pdf::loadView('backend.utils.print.transactions.out', compact('sales'))->setPaper('a4', 'landscape')->setOptions(['dpi' => 90, 'defaultFont' => 'Source Sans Pro', 'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true]);
        return $pdf->stream('invoice.pdf');
    }

    public function payment(Request $request, Sales $sales)
    {
        $sales->with('customer', 'details', 'transaction');

        $transaction = $sales->transaction;

        if ($transaction->hasPayment()) {
            return redirect()->route('admin.sales.index')->withFlashDanger(__('This sales already has payment.'));
        }

        $payment = $transaction->payment()->create([
            'amount' => $request->payment,
            'code' => 'PYMNT-'.$transaction->code
        ]);

        if ($payment) {
            $transaction->update([
                'status' => 'paid',
            ]);
        }

        return redirect()->route('admin.sales.show', ['sales' => $sales])->withFlashSuccess(__('Payment transaction successfully created.'));
    }
}
