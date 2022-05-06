@extends('backend.layouts.app')

@section('title', __('All Transactions'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('All Transactions')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.transaction.create')"
                :text="__('Add Transaction')"
            />
        </x-slot>

        @slot('body')
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover table-strip table-sm">
                        <thead>
                            <tr>
                                <td>@lang('Invoice Number')</td>
                                <td>@lang('Customer')</td>
                                <td>@lang('Total Price')</td>
                                <td>@lang('Created Date')</td>
                                <td>@lang('Action')</td>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($transactions->count() > 0)
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->invoice_number }}</td>
                                        <td>{{ $transaction->customer->name }}</td>
                                        <td>{{ $transaction->total }}</td>
                                        <td>@displayDate($transaction->created_at, 'Y-M-d')</td>
                                        <td>
                                            <a href="#"><i class="fas fa-print"></i></a>
                                            <a href="{{ route('admin.transaction.show', $transaction) }}"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <strong>@lang('No Transaction Found')</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endslot
    </x-backend.card>
@endsection

