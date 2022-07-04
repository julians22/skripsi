@extends('backend.layouts.app')

@section('title', __('All Product Categories'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('All Product Categories')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link
            icon="c-icon cil-plus"
            class="card-header-action"
            :href="route('admin.category.create')"
            :text="__('Create Product Category')"
        />
    </x-slot>

    @slot('body')
        <div class="row">
            <div class="col-md-12">
                <livewire:backend.inventory.product-category-table />
            </div>
        </div>
    @endslot
</x-backend.card>
@endsection

