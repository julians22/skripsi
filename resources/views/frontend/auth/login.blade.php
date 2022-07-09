@extends('frontend.layouts.app')

@section('title', __('Login'))

@section('content')
<div class="form-wrapper">
    <x-forms.post :action="route('frontend.auth.login')">
        <div class="form-style">
            <input id="email" name="email" type="email" placeholder="@lang('E-mail Address')"  value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" >
            <span>@lang('E-mail Address')</span>
        </div>

        <div class="form-style">
            <input type="password" name="password" id="password" placeholder="@lang('Password')" maxlength="100" required autocomplete="current-password" >
            <span>@lang('Password')</span>
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-primary" type="submit">@lang('Login')</button>
            <x-utils.link :href="route('frontend.auth.password.request')" class="btn btn-link" :text="__('Forgot Your Password?')" />
        </div><!--form-group-->
    </x-forms.post>
</div>
@endsection
