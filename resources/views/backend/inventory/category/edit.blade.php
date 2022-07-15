@extends('backend.layouts.app')

@section('title', __('Update Product Category'))

@section('content')
<x-forms.patch :action="route('admin.category.update', ['productCategory' => $category])">
    <x-backend.card>
        @slot('header')
            @lang('Update Product Category')
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
                <label for="name" class="col-form-label col-md-2">Category Name</label>
                <div class="col-md-10">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name for product category" required
                        value="{{ $category->name }}"
                        >
                </div>
            </div>
            <div class="row form-group">
                <label for="description" class="col-form-label col-md-2">Description</label>
                <div class="col-md-10">
                    <textarea name="description" id="description" class="form-control" placeholder="Description">
                        {{ $category->description }}
                    </textarea>
                </div>
            </div>
        @endslot

        <x-slot name="footer">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        </x-slot>
    </x-backend.card>
</x-forms.patch>
@endsection


