@extends('backend.layouts.app')

@section('title', __('Show Product'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Show Product')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link class="card-header-action" :href="route('admin.product.index')" :text="__('Back')" />
    </x-slot>

    <x-slot name="body">
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <th>@lang('Product Name')</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Code')</th>
                        <td>{{ $product->code }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Category Product')</th>
                        <td>{{ $product->category->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Stock Available')</th>
                        <td>{{ $product->quantity }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Sell Price')</th>
                        <td>{{ rupiah($product->price) }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Product Description')</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <img onerror="this.onerror=null;this.src='{{ asset('img/product/placeholder-image.png') }}';" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        @lang('Last Updated') <span>{{ $product->updated_at->diffForHumans() }}</span>
    </x-slot>

</x-backend.card>
@endsection
