<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('languages')[app()->getLocale()]['code']) }}">

<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        @if (isset($title))
            {{ $title }}
            &nbsp;─&nbsp;
        @endif

        {{ config('app.name', 'Sintas') }}
    </title>
    <link rel="canonical" href="https://membasuh.com" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logos/favicon.ico') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link type="text/css" rel="stylesheet" href="{{ asset('themes/main/plugins/global/plugins.bundle.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('themes/main/css/style.bundle.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/jquery-confirm/jquery-confirm.min.css') }}" />

    <style>
        .heart-svg {
            fill: red;
            position: relative;
            top: -1px;
            height: 6pt;
            animation: pulse 1s ease infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Additional Stylesheets(used for this page only)-->
    @if (isset($style))
        {{ $style }}
    @endif
    <!--end::Additional Stylesheets-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
    data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">

    <!--begin::Theme mode setup on page load-->
    @include('layouts.main.partials.theme-mode')
    <!--end::Theme mode setup on page load-->

    <!--begin::loader-->
    <div class="app-page-loader flex-column">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-muted fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--end::Loader-->

    <!--begin::App-->
    <div id="kt_app_root" class="d-flex flex-column flex-root app-root">
        <!--begin::Page-->
        <div id="kt_app_page" class="app-page flex-column flex-column-fluid">
            <!--begin::Header-->
            @include('layouts.main.partials.header')
            <!--end::Header-->

            <!--begin::Wrapper-->
            <div id="kt_app_wrapper" class="app-wrapper flex-column flex-row-fluid">
                <!--begin::Sidebar-->
                @include('layouts.main.partials.sidebar')
                <!--end::Sidebar-->

                <!--begin::Main-->
                <div id="kt_app_main" class="app-main flex-column flex-row-fluid">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid mb-5 {{ $isCenter ? 'flex-center' : '' }}">
                        <!--begin::Content-->
                        {{ $slot }}
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->

                    <!--begin::Footer-->
                    @include('layouts.main.partials.footer')
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    {{--
    <!--begin::Drawers-->
    @include('layouts.main.partials.drawer')
    <!--end::Drawers-->
    --}}

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Modals-->
    @if (isset($modal))
        {{ $modal }}
    @endif
    <!--end::Modals-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('themes/main/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/main/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('vendor/jquery-confirm/jquery-confirm.min.js') }}"></script>

    <script>
        const appLocale = `<?= app()->getLocale() ?>`;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        const handleWaitScreen = async (targetElement = `#kt_app_body`) => {
            let blockUI = new KTBlockUI(element = document.querySelector(targetElement), {
                message: `
                    <div class="blockui-message">
                        <span class="spinner-grow text-promary me-3"></span>
                        Loading...
                    </div>
                `,
            });

            if (blockUI.isBlocked() === false) {
                blockUI.block();
            }

            await new Promise((resolve) => setTimeout(resolve, 1000));
        }

        $(document).on('click', `#logout-button`, function() {
            $.confirm({
                theme: themeMode,
                title: 'Confirm!',
                content: `Are you sure to logout?`,
                type: 'orange',
                autoClose: 'close|5000',
                buttons: {
                    close: {
                        text: 'Close',
                        btnClass: 'btn btn-sm btn-secondary',
                        keys: ['esc'],
                    },
                    confirm: {
                        text: 'Yes, Logout',
                        btnClass: 'btn btn-sm btn-danger',
                        keys: ['enter'],
                        action: function() {
                            $(`#logout-form`).submit();
                        }
                    },
                }
            });
        });
    </script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Additional Javascript(used for this page only)-->
    @if (isset($script))
        {{ $script }}
    @endif
    <!--end::Additional Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
