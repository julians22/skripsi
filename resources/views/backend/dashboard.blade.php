@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Welcome :Name', ['name' => $logged_in_user->name])
        </x-slot>

        <x-slot name="body">
            @lang('Welcome to the Dashboard')

            <div class="row mt-4">
                <div class="col-md-3">
                    <x-utils.widget>
                        <x-slot name="header">
                            <i class="fas fa-money-bill"></i>
                            @lang('Selling Today')
                        </x-slot>
                        <x-slot name="content">
                            Rp. {{ $contents['selling_today'] }}
                        </x-slot>
                    </x-utils.widget>
                </div>
                <div class="col-md-3">
                    <x-utils.widget>
                        <x-slot name="header">
                            <i class="fas fa-money-bill"></i>
                            @lang('Selling This Month')
                        </x-slot>
                        <x-slot name="content">
                            Rp. {{ $contents['selling_this_month'] }}
                        </x-slot>
                    </x-utils.widget>
                </div>
                <div class="col-md-3">
                    <x-utils.widget>
                        <x-slot name="header">
                            <i class="fas fa-money-bill"></i>
                            @lang('Selling Last Month')
                        </x-slot>
                        <x-slot name="content">
                            Rp. {{ $contents['selling_last_month'] }}
                        </x-slot>
                    </x-utils.widget>
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection
