@extends('backend.layouts.app')

@section('title', __('All Customers'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('All Customers')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link
            icon="c-icon cil-plus"
            class="card-header-action"
            :href="route('admin.customer.create')"
            :text="__('Add Customer')"
        />
    </x-slot>

    <x-slot name="body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-bordered table-hover table-strip">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Phone</td>
                            <td>Created Date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customers->count() > 0)
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->created_at }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    <strong>@lang('No Customer Found')</strong>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-backend.card>
@endsection
