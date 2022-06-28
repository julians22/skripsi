@extends('backend.layouts.app')

@section('title', __('Add Purchase'))

@section('content')

<x-forms.post :action="route('admin.purchase.store')">
    <x-backend.card>
        @slot('header')
            @lang('Add Purchase')
        @endslot

        @slot('headerActions')
            <x-utils.link
                class="card-header-action"
                :href="route('admin.purchase.index')"
                :text="__('Cancel')"
            />
        @endslot

        @slot('body')
            <transaction-in :categories_model='@json($categories ?? [])' :products_model='@json($products ?? [])' :old_selected_products='@json(old('products'))'>
                <template v-slot:select_suplier>
                    <select-suplier :suplier_model='@json($supliers ?? [])'></select-suplier>
                </template>
            </transaction-in>
        @endslot

        @slot('footer')
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Purchase')</button>
        @endslot

    </x-backend.card>
</x-forms.post>

@endsection
