@extends('backend.layouts.app')

@section('title', __('Add Transaction'))

@section('content')

<x-forms.post :action="route('admin.transaction.store')">
    <x-backend.card>
        @slot('header')
            @lang('Add Transaction')
        @endslot

        @slot('headerActions')
            <x-utils.link
                class="card-header-action"
                :href="route('admin.transaction.index')"
                :text="__('Cancel')"
            />
        @endslot

        @slot('body')
            <select-customer :customer_model="@json($customers ?? [])"></select-customer>
        @endslot

        @slot('footer')
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Transaction')</button>
        @endslot
    </x-backend.card>
</x-forms.post>

@endsection