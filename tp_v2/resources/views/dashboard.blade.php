@extends('layouts.app')
@section('content')

    <x-slot name="header">
        <h2 class="">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary overflow-hidden  sm:rounded-lg">
                <div>
                    {{ __("  You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

@endsection