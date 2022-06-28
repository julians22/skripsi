@extends('backend.layouts.app')

@section('title', __('Add Sales'))

@section('content')

<x-forms.post :action="route('admin.sales.store')">
    <x-backend.card>
        @slot('header')
            @lang('Add Sales')
        @endslot

        @slot('headerActions')
            <x-utils.link
                class="card-header-action"
                :href="route('admin.sales.index')"
                :text="__('Cancel')"
            />
        @endslot

        @slot('body')
            <transaction-out :categories_model='@json($categories ?? [])' :products_model='@json($products ?? [])' :old_selected_products='@json(old('products'))'>
                <template v-slot:select_customer>
                    <select-customer :customers_model='@json($customers ?? [])'></select-customer>
                </template>
            </transaction-out>
        @endslot

        @slot('footer')
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Sales')</button>
        @endslot
    </x-backend.card>
</x-forms.post>

@endsection

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.c-sidebar-minimizer').click();
        });
    </script>
@endpush
