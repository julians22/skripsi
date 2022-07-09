@extends('frontend.layouts.app')

@section('title', __('Reset Password'))

@section('content')
<div class="form-wrapper">
    <x-forms.post :action="route('frontend.auth.password.email')">
        <div class="form-style">
            <input id="email" name="email" type="email" placeholder="@lang('E-mail Address')"  value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" >
            <span>@lang('E-mail Address')</span>
        </div>

        <button class="btn btn-primary btn-block" type="submit">@lang('Send Password Reset Link')</button>

    </x-forms.post>
</div>
@endsection
