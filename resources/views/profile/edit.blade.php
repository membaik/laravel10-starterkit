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

        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ ucwords(__('Profile Details')) }}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->

            <!--begin::Form-->
            <form id="form_profile_details" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('profile.update') }}">
                @method('PATCH')

                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ __('Avatar') }}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url('{{ asset('themes/main/media/svg/avatars/blank.svg') }}')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url({{ auth()->user()->image_full_url }})"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label for="image"
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    title="{{ __('Change Avatar') }}">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <!--begin::Inputs-->
                                    <input type="file" id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="is_image_removed" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    title="{{ __('Cancel Avatar') }}">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    title="{{ __('Remove Avatar') }}">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">
                                {{ __('Allowed File Types :filetypes', ['filetypes' => 'png, jpg, jpeg']) }}.
                            </div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="full_name" class="col-lg-4 col-form-label required fw-semibold fs-6">
                            {{ ucwords(__('Full Name')) }}
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="text" id="full_name" name="full_name"
                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                placeholder="{{ ucwords(__('Full Name')) }}" value="{{ auth()->user()->full_name }}"
                                autocomplete="one-time-code" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">
                        {{ __('Discard') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save Changes') }}
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Basic info-->
    </div>

    <x-slot name="script">
        @vite(['resources/js/main/profile/profile-details.js', 'resources/js/main/profile/signin-methods.js'])
    </x-slot>
</x-main-app-layout>