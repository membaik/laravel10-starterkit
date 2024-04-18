<?php
$title = __('Roles');
$breadcrumbs = [
    [
        'name' => __('Roles'),
        'url' => route('roles.index'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <div class="card">
            <div class="card-header border-0 px-7 py-3">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-solid ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" table-filter="search" class="form-control form-control-solid w-250px ps-13"
                            placeholder="{{ __('Search') }}..." />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @can('role.create')
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Create-->
                            <a class="btn btn-primary" href="{{ route('roles.create') }}">
                                <i class="ki-solid ki-plus fs-2"></i>
                                {{ __('Create') }}
                            </a>
                            <!--end::Create-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                @endcan
            </div>
            <div class="card-body p-0 py-3">
                {{ $dataTable->table(['class' => 'table table-responsive table-row-dashed table-hover fs-6 gs-5 align-middle']) }}
            </div>
        </div>
    </div>

    <x-slot name="style">
        <link type="text/css" rel="stylesheet"
            href="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.css') }}" />
    </x-slot>

    <x-slot name="script">
        <script>
            var indexUrl = `{{ route('roles.index') }}`;
            var tableId = `table_role`;
        </script>

        <script src="{{ asset('themes/main/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('vendor/datatables/table-filter.js') }}"></script>
        <script src="{{ asset('vendor/form-render/delete.js') }}"></script>
        {{ $dataTable->scripts() }}

        <script>
            handleInitTableFilter(tableId, `[table-filter="search"]`);
        </script>
    </x-slot>
</x-main-app-layout>
