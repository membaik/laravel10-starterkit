<?php
$title = __('Dashboard');
$breadcrumbs = [
    [
        'name' => __('Dashboard'),
        'url' => route('dashboards.index'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content" class="mt-9 app-content flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class="col-xxl-12">
                    <!--begin::Engage widget 10-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
                            style="background-position: 100% 50%; background-image:url('{{ asset('themes/main/media/stock/900x600/42.png') }}')">
                            <!--begin::Wrapper-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                    {{ __('Welcome') }},
                                    <span class="position-relative d-inline-block text-danger">
                                        <span href="javascript:;" class="text-danger opacity-75-hover">
                                            {{ auth()->user()->full_name }}
                                        </span>
                                        <!--begin::Separator-->
                                        <span
                                            class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                        <!--end::Separator-->
                                    </span>!
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--begin::Wrapper-->

                            <!--begin::Illustration-->
                            <img class="mx-auto h-150px h-lg-200px theme-light-show"
                                src="{{ asset('themes/main/media/illustrations/misc/upgrade.svg') }}" alt="" />
                            <img class="mx-auto h-150px h-lg-200px theme-dark-show"
                                src="{{ asset('themes/main/media/illustrations/misc/upgrade-dark.svg') }}"
                                alt="" />
                            <!--end::Illustration-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Engage widget 10-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content-->
    </div>
</x-main-app-layout>
