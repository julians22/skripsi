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
                <table class="table table-sm table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($categories->count() > 0)
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 200, '...') }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    <strong>@lang('No Category Found')</strong>
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
