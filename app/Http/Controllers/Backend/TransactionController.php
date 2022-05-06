<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Transactions\Out\StoreTransactionRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('backend.transaction.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::limit(10)->get();
        $customers = Customer::limit(10)->get();
        return view('backend.transaction.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . time(),
                'customer_id' => $request->selected_customer,
                'total' => $request->total,
            ]);

            foreach ($request->products as $product) {
                $transaction->details()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['price'],
                ]);

                $product_model = Product::find($product['product_id']);
                $product_model->update([
                    'quantity' => $product_model->quantity - $product['quantity'],
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating your transaction.'.$e));
        }
        DB::commit();
        return redirect()->route('admin.transaction.index')->withFlashSuccess(__('Transaction successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction->with('customer', 'details');
        return view('backend.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function print(Transaction $transaction)
    {
        $transaction->with('customer', 'details');
        // return view('backend.utils.print.transactions.out', compact('transaction'));
        $pdf = Pdf::loadView('backend.utils.print.transactions.out', compact('transaction'));
        return $pdf->stream('invoice.pdf');
    }
}
