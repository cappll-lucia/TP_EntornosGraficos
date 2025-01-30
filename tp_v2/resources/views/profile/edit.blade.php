@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-secondary  p-4 sm:rounded-lg sm:p-8 " style="--bs-bg-opacity: .1">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-secondary p-4 sm:rounded-lg sm:p-8" style="--bs-bg-opacity: .1">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-secondary  p-4 sm:rounded-lg sm:p-8" style="--bs-bg-opacity: .1">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection