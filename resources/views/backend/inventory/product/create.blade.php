@extends('backend.layouts.app')

@section('title', __('Create New Products'))

@section('content')
<x-forms.post :action="route('admin.product.store')">
    <x-backend.card>
        @slot('header')
            @lang('Create New Products')
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
                <label for="product_name" class="col-form-label col-md-2">Product Name</label>
                <div class="col-md-10">
                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_code" class="col-form-label col-md-2">Product Code</label>
                <div class="col-md-10">
                    <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Product Code">
                </div>
            </div>
            <div class="form-group row">
                <label for="product_category" class="col-form-label col-md-2">Product Category</label>
                <div class="col-md-10">
                    <select name="product_category" id="product_category" class="form-control" required>
                        <option value="">Select Product Category</option>
                        @if ($categories->count())
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @else
                            <option disabled value="">No Product Category</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_description" class="col-form-label col-md-2">Product Description</label>
                <div class="col-md-10">
                    <textarea name="product_description" id="product_description" class="form-control" placeholder="Product Description" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_price" class="col-form-label col-md-2">Product Price</label>
                <div class="col-md-10">
                    <input type="number" name="product_price" id="product_price" class="form-control" placeholder="Product Price" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="product_stock" class="col-form-label col-md-2">Product Stock</label>
                <div class="col-md-10">
                    <input type="number" name="product_stock" id="product_stock" class="form-control" placeholder="Product Stock" required>
                </div>
            </div>
        @endslot

        <x-slot name="footer">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Product')</button>
        </x-slot>
    </x-backend.card>
</x-forms.post>
@endsection
