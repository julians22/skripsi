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
                <livewire:backend.customer-table />
            </div>
        </div>
    </x-slot>
</x-backend.card>
@endsection
