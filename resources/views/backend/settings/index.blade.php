@extends('backend.layouts.app')

@section('title', __('Settings'))

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Settings')
    </x-slot>

    <x-slot name="body">
        <div class="row">
            <div class="col-md-12">
                <form
                    action="{{ route('admin.settings.updateBulk') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @foreach ($settings as $setting)
                        @if ($setting->isImage())
                            <div class="form-group">
                                <label for="{{ $setting->setting_key }}">{{ $setting->setting_name }}</label>
                                <input type="file" class="form-control" id="{{ $setting->setting_key }}" name="{{ $setting->setting_key }}">
                            </div>
                        @else
                            <div class="form-group">
                                <label for="{{ $setting->setting_key }}">{{ $setting->setting_name }}</label>
                                <input type="text" class="form-control" id="{{ $setting->setting_key }}" name="{{ $setting->setting_key }}" value="{{ $setting->setting_value }}">
                            </div>
                        @endif
                    @endforeach

                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </form>
            </div>
        </div>
    </x-slot>
</x-backend.card>
@endsection
