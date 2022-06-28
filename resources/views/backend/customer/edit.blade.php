@extends('backend.layouts.app')

@section('title', __('Edit Customers'))

@section('content')

<x-forms.patch :action="route('admin.customer.update', ['customer' => $customer])">

    <x-backend.card>

        @slot('header')
            @lang('Edit Customer')
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
                    <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Name for customer')" required value="{{ old('name') ? old('name') : $customer->name }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-form-label col-md-2">@lang('E-mail')</label>
                <div class="col-md-10">
                    <input type="email" name="email" id="email" class="form-control" placeholder="@lang('E-mail for customer')" required value="{{ old('email') ? old('email') : $customer->email }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-form-label col-md-2">@lang('Phone')</label>
                <div class="col-md-10">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="@lang('Phone for customer')" required value="{{ old('phone') ?  old('phone') : $customer->phone }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-form-label col-md-2">@lang('Addresses')</label>
                <div class="col-md-10">
                    <textarea name="address" id="address" class="form-control" placeholder="@lang('Address for customer')">{{ old('address') ? old('address') : $customer->address }}</textarea>
                </div>
            </div>
        @endslot

        @slot('footer')
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        @endslot

    </x-backend.card>
</x-forms.patch>

@endsection
