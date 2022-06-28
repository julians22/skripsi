@extends('backend.layouts.app')

@section('title', __('All Sales'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('All Sales')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.sales.create')"
                :text="__('Add Sales')"
            />
        </x-slot>

        @slot('body')
            <div class="row">
                <div class="col-md-12">
                    <livewire:backend.transaction.sales-table />
                </div>
            </div>
        @endslot
    </x-backend.card>
@endsection

