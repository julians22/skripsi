@extends('backend.layouts.app')

@section('title', __('Create New Products'))

@section('content')
<x-forms.post :action="route('admin.product.store')">
    <x-backend.card>
        @slot('header')
            @lang('Create New Product')
        @endslot

        @slot('headerActions')
            <x-utils.link
                class="card-header-action"
                :href="route('admin.product.index')"
                :text="__('Cancel')"
            />
        @endslot

        @slot('body')
            <div class="form-group row">
                <label for="product_name" class="col-form-label col-md-2">@lang('Product Name')</label>
                <div class="col-md-10">
                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="@lang('Product Name')" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_code" class="col-form-label col-md-2">@lang('Product Code')</label>
                <div class="col-md-10">
                    <code-product placeholder="@lang('Product Code')" identifier="product_code"/>
                </div>
            </div>
            <div>
                <select-category create_route="{{ route('admin.category.create') }}" :categories_model='@json($categories)'></select-category>
            </div>
            <div class="form-group row">
                <label for="product_description" class="col-form-label col-md-2">@lang('Product Description')</label>
                <div class="col-md-10">
                    <textarea name="product_description" id="product_description" class="form-control" placeholder="@lang('Product Description')"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_price" class="col-form-label col-md-2">@lang('Price')</label>
                <div class="col-md-10">
                    <input type="number" name="product_price" id="product_price" class="form-control" placeholder="@lang('Price')" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_stock" class="col-form-label col-md-2">@lang('Stock')</label>
                <div class="col-md-10">
                    <input type="number" name="product_stock" id="product_stock" class="form-control" placeholder="@lang('Stock')" required>
                </div>
            </div>
        @endslot

        <x-slot name="footer">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Product')</button>
        </x-slot>
    </x-backend.card>
</x-forms.post>
@endsection
