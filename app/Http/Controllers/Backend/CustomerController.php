<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Customers\CreateCustomerRequest;
use App\Http\Requests\Backend\Customers\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $customer = Customer::create($request->only('name', 'email', 'phone', 'address'));
        return redirect()->route('admin.customer.index')->withFlashSuccess(__('Customer successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $unpaidTransaction = 0;
        $paidTransaction = 0;

        foreach ($customer->sales as $sale) {
            if ($sale->transaction->status === Transaction::STATUS_PENDING || !$sale->transaction->hasPayment()) {
                $unpaidTransaction+= $sale->total;
            } else {
                $paidTransaction+= $sale->total;
            }
        }

        return view('backend.customer.show', compact('customer', 'unpaidTransaction', 'paidTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('backend.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->only('name', 'email', 'phone', 'address'));
        return redirect()->route('admin.customer.index')->withFlashSuccess(__('Customer successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
