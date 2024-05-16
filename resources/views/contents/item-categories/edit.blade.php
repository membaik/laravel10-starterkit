<?php
$title = __('Edit :name', ['name' => $query->name]);
$breadcrumbs = [
    [
        'name' => __('Item Categories'),
        'url' => route('item-categories.index'),
    ],
    [
        'name' => __('Edit :name', ['name' => $query->name]),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <div class="card mb-8 mb-xl-10">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Edit :name', ['name' => $query->name]) }}</h3>
                </div>
            </div>

            <form id="form" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('item-categories.update', $query->id) }}">
                @method('PUT')

                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-sm-12 mb-10 fv-row">
                            <label class="fs-6 fw-semibold form-label">
                                {{ __('Status') }}
                            </label>
                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input type="checkbox" id="is_active" name="status" class="form-check-input w-50px"
                                    value="1" {{ $query->is_active ? 'checked' : '' }} />
                                <label class="form-check-label cursor-pointer" for="is_active">
                                    {{ __('Is Active :name', ['name' => strtolower(__('Item Category'))]) }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-10 fv-row">
                            <label class="fs-6 fw-semibold form-label">
                                {{ __('Thumbnail') }}
                            </label>

                            <div>
                                <style>
                                    .image-input-placeholder {
                                        background-image: url('{{ asset('themes/main/media/svg/files/blank-image.svg') }}');
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('{{ asset('themes/main/media/svg/files/blank-image-dark.svg') }}');
                                    }
                                </style>
                                <div class="image-input {{ $query->thumbnail_url ? '' : 'image-input-empty' }} image-input-outline image-input-placeholder"
                                    data-kt-image-input="true">
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url({{ $query->thumbnail_full_url }})"></div>
                                    <label for="thumbnail"
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="{{ __('Change Avatar') }}">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="file" id="thumbnail" name="thumbnail"
                                            accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="is_thumbnail_removed" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="{{ __('Cancel Avatar') }}">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="{{ __('Remove Avatar') }}">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                <div class="form-text">
                                    {{ __('Allowed File Types :filetypes', ['filetypes' => 'png, jpg, jpeg']) }}.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-10 fv-row">
                            <label for="name" class="fs-6 fw-semibold form-label required">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                                value="{{ $query->name }}" placeholder="{{ __('Name') }}"
                                autocomplete="one-time-code" />
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('item-categories.index') }}"
                        class="btn btn-color-gray-500 btn-active-light-secondary me-2">
                        {{ __('Back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('vendor/form-render/edit.js') }}"></script>

        <script>
            handleInitEdit(`#form`, {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Name is required",
                        },
                    },
                },
            });
        </script>
    </x-slot>
</x-main-app-layout>
