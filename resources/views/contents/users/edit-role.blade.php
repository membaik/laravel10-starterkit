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
        'name' => __('Role'),
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
                                    <h3 class="fw-bold m-0">{{ __('Roles') }}</h3>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Form-->
                            <form id="form_role" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('users.update.role', $query->id) }}">
                                @method('PUT')

                                <!--begin::Card body-->
                                <div class="card-body border-top p-9">
                                    @forelse ($roles as $item)
                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-custom form-check-solid align-items-start cursor-pointer">
                                            <!--begin::Input-->
                                            <input type="checkbox" name="role[]" class="form-check-input mt-3 me-3"
                                                value="{{ $item->id }}"
                                                {{ $query->hasRole($item->name) ? 'checked' : '' }} />
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
                                <!--end::Card body-->
                                <!--begin::Card footer-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ucwords(__('Save Changes')) }}
                                    </button>
                                </div>
                                <!--end::Card footer-->
                            </form>
                            <!--end::Form-->
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
        @vite(['resources/js/main/users/role.js'])
    </x-slot>
</x-main-app-layout>
