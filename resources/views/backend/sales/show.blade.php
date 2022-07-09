@extends('backend.layouts.app')

@section('title', __('Show Sales'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        <a href="{{ route('admin.sales.print', $sales) }}" class="btn btn-success btn-sm"><i class="fas fa-print"></i></a>
    </x-slot>

    {{-- <x-slot name="headerActions">
        <x-utils.link
            icon="fas fa-pencil-alt"
            class="card-header-action"
            :href="route('admin.sales.edit', $sales)"
            :text="__('Edit Sales')"
        />
    </x-slot> --}}

    @slot('body')
        <div class="row">
            <div class="col-md-12">
                <table class="table-sm table-borderless">
                    <tr>
                        <th>@lang('Invoice Number')</th>
                        <td>:</td>
                        <td>{{ $sales->invoice_number }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Customer')</th>
                        <td>:</td>
                        <td>{{ $sales->customer->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Total Price')</th>
                        <td>:</td>
                        <td>{{ rupiah($sales->total) }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Created Date')</th>
                        <td>:</td>
                        <td>{{ $sales->created_at->format('d-M-Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="mb-4">@lang('Sales Detail')</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>@lang('Product')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Price')</th>
                            <th class="text-right">@lang('Sub total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ rupiah($detail->unit_price) }}</td>
                                <td class="text-right">{{ rupiah($detail->total) }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-medium">
                            <th colspan="3">Total</th>
                            <th class="text-right">{{ rupiah($sales->total) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3">Discount</th>
                            <th class="text-right">- {{ rupiah($sales->discount) }}</th>
                        </tr>
                        <tr class="font-lg table-black">
                            <th colspan="3">Grand Total</th>
                            <th class="text-right">{{ rupiah($sales->grand_total) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endslot
</x-backend.card>

<x-backend.card>

    <x-slot name="body">

        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="mb-4">@lang('Payment Detail')</h5>

                @if ($sales->transaction->hasPayment())

                    @php
                        $transaction = $sales->transaction;
                        $payment = $transaction->payment;
                    @endphp

                    <table class="table table-sm">
                        <tr>
                            <th>@lang('Payment Date')</th>
                            <td>@displayDate($payment->created_at, 'Y/m/d')</td>
                        </tr>
                        <tr>
                            <th>@lang('Payment Amount')</th>
                            <td>{{ rupiah($payment->amount) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Status')</th>
                            <td>{{ __($transaction->status) }}</td>
                        </tr>
                    </table>
                @else
                    <form method="POST" action="{{ route('admin.sales.payment.store', ['sales' => $sales]) }}">
                        @csrf
                        <create-payment-component
                            grand-total="{{ $sales->grand_total }}"
                            grand-total-label="{{ rupiah($sales->grand_total) }}"
                            alert-message="@lang('No payment found for this transaction.')"
                            add-btn-text="@lang('Add Payment')"
                            save-btn-text="@lang("Save")"
                            total-label-text="@lang('Total Price')"
                            full-payment-label="@lang('Full Payment')"
                            pay-amount-label="@lang('Pay Amount')"
                            />
                    </form>
                @endif
            </div>
        </div>
    </x-slot>
</x-backend.card>
@endsection

