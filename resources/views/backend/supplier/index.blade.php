@extends('backend.layouts.app')

@section('title', 'All Suppliers')

@section('content')
    <x-backend.card>
        @slot('header')
            @lang('All Suppliers')
        @endslot

        @slot('headerActions')
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.supplier.create')"
                :text="__('Add Supplier')"
            />
        @endslot

        @slot('body')
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm table-bordered table-hover table-strip">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Phone</td>
                                <td>Created Date</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($suppliers->count() > 0)
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>{{ $supplier->created_at }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <strong>@lang('No Supplier Found')</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endslot
    </x-backend.card>
@endsection
