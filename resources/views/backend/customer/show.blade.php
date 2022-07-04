@extends('backend.layouts.app')

@section('title', __('Show Customer'))

@section('content')
    <x-backend.card>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-pencil" class="card-header-action" :href="route('admin.customer.edit', $customer->id)" :text="__('Edit Customer')" />

            <x-utils.link icon="c-icon cil-trash" class="card-header-action" :href="route('admin.customer.destroy', $customer->id)" :text="__('Delete Customer')"
                :confirm="__('Are you sure you want to delete this customer?')" :method="'delete'" />
        </x-slot>

        <x-slot name="body">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title">{{ $customer->name }}</h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end">
                        <div class="mr-4">
                            <h5 class="mb-0">{{ rupiah($paidTransaction) }}</h5>
                            <small class="text-success">Transaksi Terbayar</small>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ rupiah($unpaidTransaction) }}</h5>
                            <small class="text-danger">Transaksi Terutang</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">@lang('Profile')</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="false">@lang('Transaction')</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <td>{{ $customer->name }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('E-mail Address')</th>
                                            <td>{{ $customer->email }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('Phone')</th>
                                            <td>{{ $customer->phone }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('Addresses')</th>
                                            <td>{{ $customer->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                            <tr>
                                                <th>@lang('Invoice Number')</th>
                                                <th>@lang('Status')</th>
                                                <th>@lang('Total')</th>
                                                <th>@lang('Created Date')</th>
                                                <th>@lang('Actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->sales as $sales)
                                                <tr>
                                                    <td>
                                                        <span class="badge badge-indigo">
                                                            {{ $sales->invoice_number }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        @if ($sales->transaction->hasPayment())
                                                            @if ($sales->status_label == 'paid')
                                                                <span class="badge badge-success">
                                                                    {{ __($sales->status_label) }}
                                                                </span>
                                                            @elseif ($sales->status_label == 'canceled')
                                                                <span class="badge badge-danger">
                                                                    {{ __($sales->status_label) }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-warning">
                                                                    {{ __($sales->status_label) }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-danger">
                                                                @lang('payment not found')
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        {{ rupiah($sales->total) }}
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-orange">@displayDate($sales->created_at, 'Y-M-d')</span>
                                                    </td>

                                                    <td>
                                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="@lang('Print Invoice')" class="btn btn-sm m-0 btn-primary p-px" href="{{ route('admin.sales.print', ['sales' => $sales]) }}"><i class="fas fa-print"></i></a>
                                                        <a data-toggle="tooltip" data-placement="top" title="@lang('Show Sales')" class="btn btn-sm m-0 btn-success p-px" href="{{ route('admin.sales.show', ['sales' => $sales]) }}"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection
