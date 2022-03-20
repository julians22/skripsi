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
                    <table class="table table-bordered table-hoverable table-strip">
                        <thead>
                            <tr>
                                <td>Invoice Number</td>
                                <td>Customer</td>
                                <td>Total Price</td>
                                <td>Created Date</td>
                                <td>Action</td>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($transactions->count() > 0)
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->invoice_number }}</td>
                                        <td>{{ $transaction->customer->name }}</td>
                                        <td>{{ $transaction->total }}</td>
                                        <td>{{ $transaction->created_at }}</td>
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

