<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">
        <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div id="kt_app_sidebar_mobile_toggle" class="btn btn-icon btn-active-color-primary w-35px h-35px">
                <i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->

        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <div class="d-lg-none">
                <img alt="Logo" src="{{ asset(config('app.landscape_light_image_url')) }}"
                    class="h-25px theme-light-show" />
                <img alt="Logo" src="{{ asset(config('app.landscape_dark_image_url')) }}"
                    class="h-25px theme-dark-show" />
            </div>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Header wrapper-->
        <div id="kt_app_header_wrapper" class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
                class="page-title d-flex flex-column justify-content-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    @if (isset($title))
                        {{ $title }}
                    @else
                        {{ config('app.full_name') }}
                    @endif
                </h1>
                <!--end::Title-->

                @if (count($breadcrumbs))
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        @foreach ($breadcrumbs as $breadcrumb)
                            <!--begin::Item-->
                            @if ($breadcrumb['url'] && $loop->last === false)
                                <li class="breadcrumb-item text-muted">
                                    <a href="{{ $breadcrumb['url'] }}"
                                        class="text-muted text-hover-primary">{{ $breadcrumb['name'] }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item text-muted">{{ $breadcrumb['name'] }}</li>
                            @endif
                            <!--end::Item-->

                            @if ($loop->last === false)
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-500 w-8px h-2px"></span>
                                </li>
                                <!--end::Item-->
                            @endif
                        @endforeach
                    </ul>
                    <!--end::Breadcrumb-->
                @endif
            </div>
            <!--end::Page title-->

            <!--begin::Navbar-->
            @include('layouts.main.partials.navbar')
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
