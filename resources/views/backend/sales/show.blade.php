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
                    <div class="alert alert-warning">
                        @lang('No payment found for this transaction.')
                        <a data-toggle="modal" data-target="#paymentModal" href="#" class="btn btn-sm btn-light">@lang('Add Payment')</a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-backend.card>
@endsection

@push('before-scripts')
<form method="POST" action="{{ route('admin.sales.payment', ['sales' => $sales]) }}">
    @csrf
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                        @lang('Add Payment')
                        <span class="badge badge-pill badge-info">{{ $sales->invoice_number }}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            @lang('Total Price')
                        </div>
                        <div class="col-md-8">
                            <strong>
                                {{ rupiah($sales->grand_total) }}
                            </strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment" class="col-form-label">@lang('Pay Amount')</label>
                        {{-- create input group --}}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" name="payment" id="payment" placeholder="@lang('Insert Pay Amount')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">@lang("Save")</button>
                </div>
            </div>
        </div>
  </div>
</form>
@endpush
