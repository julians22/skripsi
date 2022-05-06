@extends('backend.layouts.app')

@section('title', __('Show Transaction'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        <a href="{{ route('admin.transaction.print', $transaction) }}" class="btn btn-success btn-sm"><i class="fas fa-print"></i></a>
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link
            icon="fas fa-pencil-alt"
            class="card-header-action"
            :href="route('admin.transaction.edit', $transaction)"
            :text="__('Edit Transaction')"
        />
    </x-slot>

    @slot('body')
        <div class="row">
            <div class="col-md-4">
                <table class="table-sm table-borderless">
                    <tr>
                        <th>@lang('Invoice Number')</th>
                        <td>:</td>
                        <td>{{ $transaction->invoice_number }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Customer')</th>
                        <td>:</td>
                        <td>{{ $transaction->customer->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Total Price')</th>
                        <td>:</td>
                        <td>{{ $transaction->total }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Created Date')</th>
                        <td>:</td>
                        <td>{{ $transaction->created_at->format('d-M-Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="mb-4">@lang('Detail Transaction')</h5>
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
                        @foreach ($transaction->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->unit_price, 2) }}</td>
                                <td class="text-right">{{ number_format($detail->total, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-lg">
                            <th colspan="3">Total</th>
                            <th class="text-right">{{ number_format($transaction->total, 2) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endslot
</x-backend.card>
@endsection
