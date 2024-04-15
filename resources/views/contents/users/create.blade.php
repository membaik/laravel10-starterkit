<?php
$title = __('Create :name', ['name' => __('User')]);
$breadcrumbs = [
    [
        'name' => __('User'),
        'url' => route('users.index'),
    ],
    [
        'name' => __('Create'),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <div id="div_create_account_stepper"
            class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10">
            <!--begin::Aside-->
            <div
                class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px">
                <!--begin::Wrapper-->
                <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                    <!--begin::Nav-->
                    <div class="stepper-nav">
                        <!--begin::Step-->
                        <div data-kt-stepper-element="nav" class="stepper-item current">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{ ucwords(__('Personal Info')) }}</h3>
                                    <div class="stepper-desc fw-semibold">{{ __('Personal Related Info') }}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step-->

                        <!--begin::Step-->
                        <div data-kt-stepper-element="nav" class="stepper-item">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{ ucwords(__('Account Details')) }}</h3>
                                    <div class="stepper-desc fw-semibold">{{ __('Setup Account Details') }}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step-->

                        <!--begin::Step-->
                        <div data-kt-stepper-element="nav" class="stepper-item">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">{{ ucwords(__('Roles')) }}</h3>
                                    <div class="stepper-desc fw-semibold">{{ __('Setup Roles') }}</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Step-->
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Aside-->

            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                <!--begin::Form-->
                <form id="form_create_account" onsubmit="return false" novalidate="novalidate"
                    class="card-body py-20 w-100 px-9" data-url-action="{{ route('users.store') }}">
                    <!--begin::Step-->
                    <div data-kt-stepper-element="content" class="current">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-10 pb-lg-12">
                                <!--begin::Title-->
                                <h2 class="fw-bold text-gray-900">{{ ucwords(__('Personal Info')) }}</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label">
                                    {{ ucwords(__('Status')) }}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div
                                    class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                    <input type="checkbox" id="is_active" name="status" class="form-check-input w-50px"
                                        value="1" checked="" />
                                    <label class="form-check-label cursor-pointer" for="is_active">
                                        Is this account active?
                                    </label>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label required">
                                    {{ ucwords(__('Full Name')) }}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="full_name"
                                    class="form-control form-control-lg form-control-solid" value=""
                                    placeholder="{{ ucwords(__('Full Name')) }}" autocomplete="one-time-code" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step-->

                    <!--begin::Step-->
                    <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-10 pb-lg-12">
                                <!--begin::Title-->
                                <h2 class="fw-bold text-gray-900">{{ ucwords(__('Account Details')) }}</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label for="email" class="fs-6 fw-semibold form-label required">
                                    {{ ucwords(__('Email')) }}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="email" name="email"
                                    class="form-control form-control-lg form-control-solid" value=""
                                    placeholder="{{ ucwords(__('Email')) }}" autocomplete="one-time-code" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-10">
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label for="password" class="fs-6 fw-semibold form-label required">
                                        {{ ucwords(__('Password')) }}
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="{{ ucwords(__('Password')) }}" autocomplete="one-time-code" />
                                    <!--end::Input-->
                                </div>
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label for="password_confirmation" class="fs-6 fw-semibold form-label required">
                                        {{ ucwords(__('Confirm Password')) }}
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="{{ ucwords(__('Confirm Password')) }}"
                                        autocomplete="one-time-code" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step-->

                    <!--begin::Step-->
                    <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-10 pb-lg-15">
                                <!--begin::Title-->
                                <h2 class="fw-bold text-gray-900">{{ ucwords(__('Roles')) }}</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row">
                                @forelse ($roles as $item)
                                    <!--begin::Option-->
                                    <label
                                        class="form-check form-check-custom form-check-solid align-items-start cursor-pointer">
                                        <!--begin::Input-->
                                        <input type="checkbox" name="role[]" class="form-check-input mt-3 me-3"
                                            value="{{ $item->id }}" />
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <span class="form-check-label d-flex flex-column align-items-start">
                                            <span class="fw-bold fs-5 mb-0">{{ $item->name }}</span>
                                            <span class="text-muted fs-6">
                                                <span class="text-nowrap">
                                                    {!! $item->permissions->sortBy('name')->pluck('name')->join('<span class="h5">,</span></span> <span class="text-nowrap">') !!}
                                                </span>
                                            </span>
                                        </span>
                                        <!--end::Label-->
                                    </label>
                                    <!--end::Option-->

                                    @if ($loop->last === false)
                                        <!--begin::Option-->
                                        <div class="separator separator-dashed my-5"></div>
                                        <!--end::Option-->
                                    @endif
                                @empty
                                @endforelse
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step-->

                    <!--begin::Actions-->
                    <div class="d-flex flex-stack pt-10">
                        <!--begin::Wrapper-->
                        <div class="mr-2">
                            <button type="button" class="btn btn-lg btn-light-primary me-3"
                                data-kt-stepper-action="previous">
                                <i class="ki-duotone ki-arrow-left fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('Back') }}
                            </button>
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Wrapper-->
                        <div>
                            <button type="button" class="btn btn-lg btn-primary me-3"
                                data-kt-stepper-action="submit">
                                <span class="indicator-label">
                                    {{ __('Submit') }}
                                    <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="indicator-progress">
                                    {{ __('Please Wait') }}...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                {{ __('Continue') }}
                                <i class="ki-duotone ki-arrow-right fs-4 ms-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>

    <x-slot name="script">
        @vite(['resources/js/main/users/create.js'])
    </x-slot>
</x-main-app-layout>
