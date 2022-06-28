@extends('backend.layouts.app')

@section('title', __('Create Customers'))

@section('content')

<x-forms.post :action="route('admin.customer.store')">

    <x-backend.card>

        @slot('header')
            @lang('Create New Customer')
        @endslot

        @slot('headerActions')
            <x-utils.link
                class="card-header-action"
                :href="route('admin.customer.index')"
                :text="__('Cancel')"
            />
        @endslot

        @slot('body')
            <div class="form-group row">
                <label for="name" class="col-form-label col-md-2">@lang('Name')</label>
                <div class="col-md-10">
                    <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Name for customer')" required value="{{ old('name') ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-form-label col-md-2">@lang('E-mail')</label>
                <div class="col-md-10">
                    <input type="email" name="email" id="email" class="form-control" placeholder="@lang('E-mail for customer')" required value="{{ old('email') ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-form-label col-md-2">@lang('Phone')</label>
                <div class="col-md-10">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="@lang('Phone for customer')" required value="{{ old('phone') ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-form-label col-md-2">@lang('Addresses')</label>
                <div class="col-md-10">
                    <textarea name="address" id="address" class="form-control" placeholder="@lang('Address for customer')">{{ old('address') ?? '' }}</textarea>
                </div>
            </div>
        @endslot

        @slot('footer')
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create')</button>
        @endslot

    </x-backend.card>
</x-forms.post>

@endsection
