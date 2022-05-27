@extends('backend.layouts.app')

@section('title', __('All Purchases'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('All Purchases')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link
            icon="c-icon cil-plus"
            class="card-header-action"
            :href="route('admin.purchase.create')"
            :text="__('Add Purchase')"
        />
    </x-slot>

    @slot('body')
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-strip table-sm">
                    <thead>
                        <tr>
                            <td>@lang('Supplier')</td>
                            <td>@lang('Product')</td>
                            <td>@lang('Price')</td>
                            <td>@lang('Quantity')</td>
                            <td>@lang('Created Date')</td>
                            <td>@lang('Action')</td>
                        </tr>
                    </thead>

                    @if ($purchases->count() > 0)
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ $purchase->product->name }}</td>
                                <td>{{ $purchase->price }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>@displayDate($purchase->created_at, 'Y-M-d')</td>
                                <td>
                                    <a href="{{ route('admin.purchase.show', $purchase) }}"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @else
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">
                                <strong>@lang('No Purchase Found')</strong>
                            </td>
                        </tr>
                    </tbody>
                    @endif
                </table>
                {{ $purchases->links() }}
            </div>
        </div>
    @endslot
</x-backend.card>
@endsection
