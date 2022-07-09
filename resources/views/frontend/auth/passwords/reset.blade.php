@extends('frontend.layouts.app')

@section('title', __('Reset Password'))

@section('content')

<div class="form-wrapper">
    <x-forms.post :action="route('frontend.auth.password.update')">
        <input type="hidden" name="token" value="{{ $token }}" />
        <div class="form-style">
            <input type="email" name="email" id="email" placeholder="{{ __('E-mail Address') }}" value="{{ $email ?? old('email') }}" maxlength="255" required autofocus autocomplete="email" />
            <span>{{ __('E-mail Address') }}</span>
        </div>
        <div class="form-style">
            <input type="password" id="password" name="password" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="password" />
            <span>{{ __('Password') }}</span>
        </div>
        <div class="form-style">
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />
            <span>{{ __('Password Confirmation') }}</span>
        </div>

        <button class="btn btn-primary btn-block" type="submit">@lang('Reset Password')</button>
    </x-forms.post>
</div>
@endsection
