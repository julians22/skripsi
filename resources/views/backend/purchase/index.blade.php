@extends('backend.layouts.app')

@section('title', __('All Purchases'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('All Purchases')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link
            icon="c-icon cil-plus"
            class="card-header-action"
            :href="route('admin.purchase.create')"
            :text="__('Add Purchase')"
        />
    </x-slot>

    @slot('body')
        <div class="row">
            <div class="col-md-12">
                <livewire:backend.transaction.purchase-table />
            </div>
        </div>
    @endslot
</x-backend.card>
@endsection
