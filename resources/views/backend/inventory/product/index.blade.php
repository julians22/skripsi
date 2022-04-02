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
                    <table class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <td>Code</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Stock Available</td>
                                <td>Category</td>
                                <td>Action</td>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($products->count() > 0)
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->category->name ?? 'Not Categoried' }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <strong>@lang('No Product Found')</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endslot
    </x-backend.card>
@endsection
