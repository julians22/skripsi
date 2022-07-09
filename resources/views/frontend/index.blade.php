@extends('frontend.layouts.app')

@section('title', __('Selamat Datang'))

@section('content')
@guest
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
@else
    @if ($logged_in_user->isAdmin())
        <x-utils.link
            :href="route('admin.dashboard')"
            :text="__('Dashboard')"
            class="btn btn-success btn-block" />
    @endif
    <x-utils.link
        :text="__('Logout')"
        class="btn btn-danger btn-block mt-2"
        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
    <x-slot name="text">
        @lang('Logout')
        <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
    </x-slot>
</x-utils.link>

@endguest
@endsection
