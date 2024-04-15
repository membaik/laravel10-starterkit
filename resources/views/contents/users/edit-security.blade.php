<?php
$title = __('Edit :name', ['name' => $query->full_name]);
$breadcrumbs = [
    [
        'name' => __('Users'),
        'url' => route('users.index'),
    ],
    [
        'name' => __('Edit :name', ['name' => $query->full_name]),
        'url' => route('users.edit', $query->id),
    ],
    [
        'name' => __('Security'),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Sidebar-->
            @include('contents.users.partials.sidebar')
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                @include('contents.users.partials.navbar')
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade show active">
                        <!--begin::Card-->
                        <div class="card mb-8 mb-xl-10">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">{{ ucwords(__('Sign-in Method')) }}</h3>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Email Address-->
                                <div class="d-flex flex-wrap align-items-center">
                                    <!--begin::Label-->
                                    <div id="div_email_show">
                                        <div class="fs-6 fw-bold mb-1">{{ ucwords(__('Email Address')) }}</div>
                                        <div class="fw-semibold text-gray-600">{{ $query->email }}</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Edit-->
                                    <div id="div_email_edit" class="flex-row-fluid d-none">
                                        <!--begin::Form-->
                                        <form id="form_email" onsubmit="return false" novalidate="novalidate"
                                            class="form"
                                            data-url-action="{{ route('users.update.email', $query->id) }}">
                                            @method('PUT')

                                            <div class="row mb-6">
                                                <div class="col-lg-12 mb-4 mb-lg-0">
                                                    <div class="fv-row mb-0">
                                                        <label for="email" class="form-label fs-6 fw-bold mb-3">
                                                            {{ ucwords(__('Enter New Email Address')) }}
                                                        </label>
                                                        <input type="email" id="email" name="email"
                                                            class="form-control form-control-lg form-control-solid"
                                                            value="{{ $query->email }}"
                                                            placeholder="{{ ucwords(__('Email Address')) }}"
                                                            autocomplete="one-time-code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button type="submit" id="button_email_submit"
                                                    class="btn btn-primary me-2 px-6">
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
                                        <button id="button_email_edit_open"
                                            class="btn btn-light btn-active-light-primary">
                                            {{ ucwords(__('Change Email')) }}
                                        </button>
                                    </div>
                                    <!--end::Action-->
                                </div>
                                <!--end::Email Address-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-6"></div>
                                <!--end::Separator-->
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
                                        <form id="form_password" onsubmit="return false" novalidate="novalidate"
                                            class="form"
                                            data-url-action="{{ route('users.update.password', $query->id) }}">
                                            @method('PUT')

                                            <div class="row mb-1">
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-0">
                                                        <label for="new_password" class="form-label fs-6 fw-bold mb-3">
                                                            {{ ucwords(__('New Password')) }}
                                                        </label>
                                                        <input type="password" id="new_password" name="password"
                                                            class="form-control form-control-lg form-control-solid"
                                                            autocomplete="one-time-code" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-0">
                                                        <label for="password_confirmation"
                                                            class="form-label fs-6 fw-bold mb-3">
                                                            {{ ucwords(__('Confirm New Password')) }}
                                                        </label>
                                                        <input type="password" id="password_confirmation"
                                                            name="password_confirmation"
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
                                        <button id="button_password_edit_open"
                                            class="btn btn-light btn-active-light-primary">
                                            {{ ucwords(__('Reset Password')) }}
                                        </button>
                                    </div>
                                    <!--end::Action-->
                                </div>
                                <!--end::Password-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>

    <x-slot name="script">
        @vite(['resources/js/main/profile/signin-methods.js'])
    </x-slot>
</x-main-app-layout>
