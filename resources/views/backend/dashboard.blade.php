@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Welcome :Name', ['name' => $logged_in_user->name])
        </x-slot>

        <x-slot name="body">
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
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

            <div class="row">
                <div class="col-md-4">
                    <x-utils.widget>
                        <x-slot name="header">
                            <i class="fas fa-money-bill"></i>
                            @lang('Purchasing Today')
                        </x-slot>
                        <x-slot name="content">
                            Rp. {{ $contents['purchasing_today'] }}
                        </x-slot>
                    </x-utils.widget>
                </div>
                <div class="col-md-4">
                    <x-utils.widget>
                        <x-slot name="header">
                            <i class="fas fa-money-bill"></i>
                            @lang('Purchasing This Month')
                        </x-slot>
                        <x-slot name="content">
                            Rp. {{ $contents['purchasing_this_month'] }}
                        </x-slot>
                    </x-utils.widget>
                </div>
                <div class="col-md-4">
                    <x-utils.widget>
                        <x-slot name="header">
                            <i class="fas fa-money-bill"></i>
                            @lang('Purchasing Last Month')
                        </x-slot>
                        <x-slot name="content">
                            Rp. {{ $contents['purchasing_last_month'] }}
                        </x-slot>
                    </x-utils.widget>
                </div>
            </div>
        </x-slot>
    </x-backend.card>

    <div class="row">
        <div class="col-md-4">
            @livewire('backend.widgets.down-stock-component')
        </div>
        <div class="col-md-8">
            @livewire('backend.widgets.sales-debt')
        </div>
    </div>
    <x-backend.card>
        <x-slot name="body">
            <full-calendar-component
                :purchases='@json($contents['purchase_events'])'
                :sales='@json($contents['sale_events'])'/>
        </x-slot>
    </x-backend.card>

@endsection
