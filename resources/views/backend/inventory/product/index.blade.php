@extends('backend.layouts.app')

@section('title', __('All Products'))

@section('breadcrumb-links')
    @include('backend.inventory.product.includes.breadcrumb-links')
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('All Products')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('admin.product.create')" :text="__('Create Product')" />
            <x-utils.link icon="c-icon cil-arrow-bottom" class="card-header-action" :href="route('admin.product.import')" :text="__('Import Product')" />
            <a href="#" class="card-header-action" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-print"></i>
                @lang('Generate Price List')
            </a>
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

@push('before-scripts')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.product.price-list') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Generate Price List')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">@lang('Paper Size')</label>
                        <select name="paper_size" id="paper_size" class="form-control">
                            <option value="A4">A4</option>
                            <option value="A5">A5</option>
                            <option value="A6">A6</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn-primary">@lang('Generate')</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endpush
