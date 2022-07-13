@extends('backend.layouts.app')

@section('title', __('Import Products'))

@section('breadcrumb-links')
    @include(
        'backend.inventory.product.includes.breadcrumb-links'
    )
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Import Products')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                class="card-header-action"
                :href="route('admin.product.index')"
                :text="__('Cancel')"
            />
        </x-slot>

        @slot('body')
            <div class="row">
                <div class="col-md-12">
                    <livewire:products.product-import />
                </div>
            </div>
        @endslot
    </x-backend.card>
@endsection
