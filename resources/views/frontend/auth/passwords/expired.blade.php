@extends('frontend.layouts.app')

@section('title', __('Your password has expired.'))

@section('content')

<div class="form-wrapper">
    <x-forms.patch :action="route('frontend.auth.password.expired.update')">
        <div class="form-style">
            <input type="password" name="current_password" placeholder="{{ __('Current Password') }}" maxlength="100" required autofocus />
            <span>{{ __('Current Password') }}</span>
        </div>
        <div class="form-style">
            <input type="password" id="password" name="password" placeholder="{{ __('New Password') }}" maxlength="100" required autocomplete="password" />
            <span>{{ __('New Password') }}</span>
        </div>
        <div class="form-style">
            <input type="password" id="password_confirmation" name="password_confirmation" maxlength="100" placeholder="{{ __('Password Confirmation') }}" required autocomplete="new-password" />
            <span>{{ __('Password Confirmation') }}</span>
        </div>

        <button class="btn btn-block btn-primary" type="submit">@lang('Update Password')</button>

    </x-forms.patch>
</div>
@endsection
