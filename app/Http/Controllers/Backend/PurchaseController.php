<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Transactions\Purchases\StorePurchasesRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::with('supplier')->paginate(10);
        return view('backend.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supliers = Supplier::all();
        $products = Product::limit(10)->get();
        $categories = ProductCategory::get();

        return view('backend.purchase.create', compact('supliers', 'products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchasesRequest $request)
    {
        if ($request->suplier == 0 || $request->suplier == null) {
            $suplier = Supplier::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        }else{
            $suplier = Supplier::find($request->suplier);
        }
        $code = 'INV-P/' . date('Ymdhis') . '/'. $suplier->id .'/' . Uuid::uuid4()->toString();
        $purchase = Purchase::create([
            'invoice_number' => $code,
            'supplier_id' => $suplier->id,
            'total' => $request->total,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->products as $product) {
            $purchase->details()->create([
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);

            $product_model = Product::find($product['product_id']);
            $product_model->update([
                'quantity' => $product_model->quantity + $product['quantity'],
            ]);
        }

        if ($purchase) {
            $purchase->transaction()->create([
                'total' => $purchase->total,
                'status' => Transaction::STATUS_PENDING,
                'code' => 'PUR-' . Uuid::uuid4()->toString(),
            ]);

            return redirect()->route('admin.purchase.show', ['purchase' => $purchase])->withFlashSuccess(__('Purchase transaction successfully created.'));
        }

        return redirect()->route('admin.purchase.create')->withFlashDanger(__('Something went wrong, please try again.'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchase = Purchase::with('supplier', 'details', 'transaction')->find($purchase->id);
        return view('backend.purchase.show', compact('purchase'));
    }

    public function print(Purchase $purchase)
    {
        $purchase->with('customer', 'details');
        $pdf = Pdf::loadView('backend.utils.print.transactions.in', compact('purchase'))->setPaper('a4', 'landscape')->setOptions(['dpi' => 90, 'defaultFont' => 'Source Sans Pro', 'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true]);
        $date = date('Ymdhis');
        return $pdf->stream('invoice_' . $date . '.pdf');
    }

    public function payment(Request $request, Purchase $purchase)
    {
        $purchase->with('supplier', 'details', 'transaction');

        $transaction = $purchase->transaction;

        if ($transaction->hasPayment()) {
            return redirect()->route('admin.purchase.index')->withFlashDanger(__('This purchase already has payment.'));
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

        return redirect()->route('admin.purchase.show', ['purchase' => $purchase])->withFlashSuccess(__('Payment transaction successfully created.'));
    }
}
