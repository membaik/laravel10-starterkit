<?php
$title = __('Profile');
$breadcrumbs = [
    [
        'name' => __('Profile'),
        'url' => route('profile.index'),
    ],
    [
        'name' => __('Edit'),
        'url' => route('profile.edit'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <!--begin::Header-->
        @include('profile.partials.header')
        <!--end::Header-->

        <!--begin::Sign-in Method-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ ucwords(__('Sign-in Method')) }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                @can('auth.edit-email')
                    <!--begin::Email Address-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="div_email_show">
                            <div class="fs-6 fw-bold mb-1">{{ ucwords(__('Email Address')) }}</div>
                            <div class="fw-semibold text-gray-600">{{ auth()->user()->email }}</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Edit-->
                        <div id="div_email_edit" class="flex-row-fluid d-none">
                            <!--begin::Form-->
                            <form id="form_email" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('profile.update.email') }}">
                                @method('PUT')

                                <div class="row mb-6">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="fv-row mb-0">
                                            <label for="email" class="form-label fs-6 fw-bold mb-3">
                                                {{ ucwords(__('Enter New Email Address')) }}
                                            </label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg form-control-solid"
                                                value="{{ auth()->user()->email }}"
                                                placeholder="{{ ucwords(__('Email Address')) }}"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="fv-row mb-0">
                                            <label for="password" class="form-label fs-6 fw-bold mb-3">
                                                {{ ucwords(__('Confirm Password')) }}
                                            </label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" id="button_email_submit" class="btn btn-primary me-2 px-6">
                                        {{ __('Update :name', ['name' => __('Email')]) }}
                                    </button>
                                    <button type="button" id="button_email_cancel"
                                        class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->
                        <!--begin::Action-->
                        <div class="ms-auto">
                            <button id="button_email_edit_open" class="btn btn-light btn-active-light-primary">
                                {{ ucwords(__('Change Email')) }}
                            </button>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Email Address-->
                @endcan

                @can('auth.edit-password')
                    @can('auth.edit-email')
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-6"></div>
                        <!--end::Separator-->
                    @endcan
                    <!--begin::Password-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="div_password_show">
                            <div class="fs-6 fw-bold mb-1">{{ ucwords(__('Password')) }}</div>
                            <div class="fw-semibold text-gray-600">************</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Edit-->
                        <div id="div_password_edit" class="flex-row-fluid d-none">
                            <!--begin::Form-->
                            <form id="form_password" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('profile.update.password') }}">
                                @method('PUT')

                                <div class="row mb-1">
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="current_password" class="form-label fs-6 fw-bold mb-3">
                                                {{ ucwords(__('Current Password')) }}
                                            </label>
                                            <input type="password" id="current_password" name="current_password"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="new_password" class="form-label fs-6 fw-bold mb-3">
                                                {{ ucwords(__('New Password')) }}
                                            </label>
                                            <input type="password" id="new_password" name="password"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="password_confirmation" class="form-label fs-6 fw-bold mb-3">
                                                {{ ucwords(__('Confirm New Password')) }}
                                            </label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text mb-5">
                                    {{ __('Password Must Be At Least :requires', ['requires' => strtolower(__('8 Character')) . ' ' . strtolower(__('And')) . ' ' . strtolower(__('Contain Symbols'))]) }}
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2 px-6">
                                        {{ __('Update :name', ['name' => ucwords(__('Password'))]) }}
                                    </button>
                                    <button type="button" id="button_password_cancel"
                                        class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->
                        <!--begin::Action-->
                        <div class="ms-auto">
                            <button id="button_password_edit_open" class="btn btn-light btn-active-light-primary">
                                {{ ucwords(__('Reset Password')) }}
                            </button>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Password-->
                @endcan
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Sign-in Method-->
    </div>

    <x-slot name="script">
        @vite(['resources/js/main/profile/profile-details.js', 'resources/js/main/profile/signin-methods.js'])
    </x-slot>
</x-main-app-layout>
