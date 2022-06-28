@extends('backend.layouts.app')

@section('title', __('All Products'))

@section('breadcrumb-links')
    @include(
        'backend.inventory.product.includes.breadcrumb-links'
    )
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('All Products')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('admin.product.create')"
                :text="__('Create Product')" />
        </x-slot>

        @slot('body')
            <div class="row">
                <div class="col-md-12">
                    <livewire:backend.inventory.product-table />
                </div>
            </div>
        @endslot
    </x-backend.card>
@endsection
