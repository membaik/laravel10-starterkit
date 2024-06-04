<?php
$title = __('Edit :name', ['name' => $query->full_name]);
$breadcrumbs = [
    [
        'name' => __('Entities'),
        'url' => route('entities.index'),
    ],
    [
        'name' => __('Edit :name', ['name' => $query->full_name]),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <div class="card mb-8 mb-xl-10">
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Edit :name', ['name' => $query->full_name]) }}</h3>
                </div>
            </div>

            <form id="form" onsubmit="return false" novalidate="novalidate" class="form"
                data-url-action="{{ route('entities.update', $query->id) }}">
                @method('PUT')

                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-sm-6 mb-10 fv-row">
                            <label for="is_active" class="fs-6 fw-semibold form-label">
                                {{ __('Status') }}
                            </label>
                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input type="checkbox" id="is_active" name="status" class="form-check-input w-50px"
                                    value="1" {{ $query->is_active ? 'checked' : '' }} />
                                <label class="form-check-label cursor-pointer" for="is_active">
                                    {{ __('Is Active :name', ['name' => strtolower(__('Entity'))]) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-10 fv-row">
                            <label for="entity_categories" class="fs-6 fw-semibold form-label">
                                {{ __('Entity Categories') }}
                            </label>

                            @forelse ($entityCategories as $item)
                                <div class="form-check form-check-custom form-check-solid form-check-sm mt-2 mb-2">
                                    <input type="checkbox" id="entity_category_{{ $item->id }}"
                                        name="entity_categories[]" class="form-check-input cursor-pointer"
                                        value="{{ $item->id }}"
                                        {{ $query->entityCategories->contains('id', $item->id) ? 'checked' : '' }} />
                                    <label for="entity_category_{{ $item->id }}"
                                        class="form-check-label cursor-pointer"
                                        style="color: {{ $item->background_color_code }}">
                                        {{ $item->name }}
                                    </label>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-10 fv-row">
                            <label for="full_name" class="fs-6 fw-semibold form-label required">
                                {{ __('Full Name') }}
                            </label>
                            <input type="text" name="full_name"
                                class="form-control form-control-lg form-control-solid" value="{{ $query->full_name }}"
                                placeholder="{{ __('Full Name') }}" autocomplete="one-time-code" />
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('entities.index') }}" class="btn btn-light btn-active-light-secondary me-2">
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
                full_name: {
                    validators: {
                        notEmpty: {
                            message: "Full name is required",
                        },
                    },
                },
            });
        </script>
    </x-slot>
</x-main-app-layout>
