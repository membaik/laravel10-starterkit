<?php
$title = __('Profile');
$breadcrumbs = [
    [
        'name' => __('Profile'),
        'url' => route('profile.index'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="mt-9 app-container">
        <!--begin::Header-->
        @include('profile.partials.header')
        <!--end::Header-->

        <!--begin::details View-->
        <div id="kt_profile_details_view" class="card">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Profile Details') }}</h3>
                </div>
                <!--end::Card title-->

                @can('auth.edit')
                    <!--begin::Action-->
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary align-self-center">
                        {{ __('Edit :name', ['name' => __('Profile')]) }}
                    </a>
                    <!--end::Action-->
                @endcan
            </div>
            <!--begin::Card header-->

            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">
                        {{ __('Full Name') }}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ auth()->user()->full_name }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">
                        {{ __('Email') }}
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <a href="mailto:{{ auth()->user()->email }}"
                            class="fw-bold fs-6 text-gray-800 text-hover-primary me-2">{{ auth()->user()->email }}</a>
                        {{-- <span class="badge badge-success">Verified</span> --}}
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">{{ __('Roles') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">
                            {!! $query->getRoleNames()->toArray()
                                ? implode(', ', $query->getRoleNames()->toArray())
                                : '<span class="text-muted fw-light fst-italic">' . __('general.none') . '</span>' !!}
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::details View-->
    </div>
</x-main-app-layout>
