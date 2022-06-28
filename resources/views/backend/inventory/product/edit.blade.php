@extends('backend.layouts.app')

@section('title', __('Edit Product'))

@section('content')

<x-forms.patch :action="route('admin.product.update', $product)">
    <x-backend.card>
        <x-slot name="header">
            @lang('Edit Product')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link class="card-header-action" :href="route('admin.auth.user.index')" :text="__('Cancel')" />
        </x-slot>

        <x-slot name="body">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="form-group row">
                <label for="product_name" class="col-form-label col-md-2">@lang('Product Name')</label>
                <div class="col-md-10">
                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="@lang('Product Name')" required value="{{ $product->name }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="product_code" class="col-form-label col-md-2">@lang('Product Code')</label>
                <div class="col-md-10">
                    <input type="text" name="product_code" id="product_code" class="form-control" placeholder="@lang('Product Code')" readonly value="{{ $product->code }}">
                </div>
            </div>
            <div>
                <select-category create_route="{{ route('admin.category.create') }}" :categories_model='@json($categories)' title='@lang('Category Product')' :selected='@json($product->category)'></select-category>
            </div>
            <div class="form-group row">
                <label for="product_description" class="col-form-label col-md-2">@lang('Product Description')</label>
                <div class="col-md-10">
                    <textarea name="product_description" id="product_description" class="form-control" placeholder="@lang('Product Description')" required>{{ $product->description }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_price" class="col-form-label col-md-2">@lang('Price')</label>
                <div class="col-md-10">
                    <input type="number" name="product_price" id="product_price" class="form-control" placeholder="@lang('Price')" required value="{{ $product->price }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="product_stock" class="col-form-label col-md-2">@lang('Stock')</label>
                <div class="col-md-10">
                    <input type="number" name="product_stock" id="product_stock" class="form-control" placeholder="@lang('Stock')" required value="{{ $product->quantity }}">
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        </x-slot>
    </x-backend.card>
</x-forms.patch>

@endsection


