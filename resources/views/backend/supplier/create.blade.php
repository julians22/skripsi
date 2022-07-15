@extends('backend.layouts.app')

@section('title', __('Create Supplier'))

@section('content')

<x-forms.post :action="route('admin.supplier.store')">

    <x-backend.card>

        @slot('header')
            @lang('Create New Supplier')
        @endslot

        @slot('headerActions')
            <x-utils.link
                class="card-header-action"
                :href="route('admin.supplier.index')"
                :text="__('Cancel')"
            />
        @endslot

        @slot('body')
            <div class="form-group row">
                <label for="name" class="col-form-label col-md-2">Supplier Name</label>
                <div class="col-md-10">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name for supplier" required value="{{ old('name') ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-form-label col-md-2">Email</label>
                <div class="col-md-10">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email for supplier" value="{{ old('email') ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-form-label col-md-2">Phone</label>
                <div class="col-md-10">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone for supplier" required value="{{ old('phone') ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-form-label col-md-2">Address</label>
                <div class="col-md-10">
                    <textarea name="address" id="address" class="form-control" placeholder="Address for supplier">{{ old('address') ?? '' }}</textarea>
                </div>
            </div>
        @endslot

        @slot('footer')
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Supplier')</button>
        @endslot

    </x-backend.card>
</x-forms.post>

@endsection
