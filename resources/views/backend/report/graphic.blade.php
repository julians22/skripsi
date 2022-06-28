@extends('backend.layouts.app')

@section('title', 'Graphic')

@section('breadcrumb-links')
<div style="display: block; width: max-content;">
    <select-date></select-date>
</div>
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Sales Report')
    </x-slot>

    <x-slot name="body">
        <chart-out></chart-out>
    </x-slot>
</x-backend.card>
@endsection

