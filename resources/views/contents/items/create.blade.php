<?php
$title = __('Create :name', ['name' => __('Item')]);
$breadcrumbs = [
    [
        'name' => __('Items'),
        'url' => route('items.index'),
    ],
    [
        'name' => __('Create'),
        'url' => null,
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <form id="form" onsubmit="return false" novalidate="novalidate" class="form d-flex flex-column flex-lg-row"
            data-url-action="{{ route('items.store') }}">
            @method('POST')

            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <div class="card card-flush">
                    <div class="card-header border-0">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('Status') }}</h3>
                        </div>
                        <div class="card-toolbar">
                            <div id="item_status" class="rounded-circle bg-success w-15px h-15px">
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top p-9">
                        <select id="status" name="status" class="form-select mb-2" data-control="select2"
                            data-hide-search="true" data-placeholder="Select an option">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="text-muted fs-7">Set the item status.</div>
                    </div>
                </div>

                <div class="card card-flush">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('Thumbnail') }}</h3>
                        </div>
                    </div>
                    <div class="card-body border-top p-9 text-center">
                        <style>
                            .image-input-placeholder {
                                background-image: url('{{ asset('themes/main/media/svg/files/blank-image.svg') }}');
                            }

                            [data-bs-theme="dark"] .image-input-placeholder {
                                background-image: url('{{ asset('themes/main/media/svg/files/blank-image-dark.svg') }}');
                            }
                        </style>
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"></div>
                            <label for="thumbnail"
                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                title="{{ __('Browse Thumbnail') }}">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" id="thumbnail" name="thumbnail" accept=".png, .jpg, .jpeg" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                title="{{ __('Cancel Thumbnail') }}">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        <div class="text-muted fs-7">
                            Set the item thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted.
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>

                <div class="card card-flush">
                    <div class="card-header border-0">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('Item Categories') }}</h3>
                        </div>
                    </div>
                    <div class="card-body border-top p-9">
                        <label for="categories" class="form-label">Categories</label>
                        <select id="categories" name="categories[]" class="form-select mb-2" data-control="select2"
                            data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                            @forelse ($itemCategories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="text-muted fs-7">Add item to a category.</div>

                        @can('item-category.create')
                            <a href="{{ route('item-categories.create') }}" class="btn btn-sm btn-light-primary mt-7"
                                target="_blank">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Create new category
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush">
                    <div class="card-header border-0">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('General') }}</h3>
                        </div>
                    </div>
                    <div class="card-body border-top p-9">
                        <div class="mb-10 fv-row">
                            <label for="name" class="form-label required">Item Name</label>
                            <input type="text" id="name" name="name" class="form-control mb-2"
                                placeholder="Item Name" value="" autocomplete="one-time-code" />
                            <div class="text-muted fs-7">A item name is required and recommended to be unique.</div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush">
                    <div class="card-header border-0">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('Variations') }}</h3>
                        </div>
                    </div>
                    <div class="card-body border-top p-9">
                        <div class="mb-10 fv-row">
                            <label for="item_variations" class="form-label required">Add Item Variations</label>
                            <div class="d-flex flex-column gap-3" data-repeater-list>
                                <div class="form-group d-flex flex-wrap align-items-center gap-5" data-id="1"
                                    data-repeater-item>
                                    <div
                                        class="w-100 w-md-50px form-check form-switch form-check-custom form-check-success form-check-solid">
                                        <input type="checkbox" name="details[1][status]"
                                            class="form-check-input w-50px cursor-pointer" value="1"
                                            checked="" />
                                    </div>
                                    <div class="form-floating w-100 w-md-200px">
                                        <select id="details_1_unit_of_measurement"
                                            name="details[1][unit_of_measurement]" class="form-select"
                                            data-control="select2" data-hide-search="true"
                                            data-placeholder="Select a variation">
                                            <option></option>
                                            @forelse ($unitOfMeasurements as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="details_1_unit_of_measurement">Unit of Measurement</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" id="details_1_quantity" name="details[1][quantity]"
                                            class="form-control mw-100 w-200px input-number-integer" value=""
                                            placeholder="Quantity" autocomplete="one-time-code" />
                                        <label for="details_1_quantity">Quantity</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" id="details_1_cost" name="details[1][cost]"
                                            class="form-control mw-100 w-200px input-number-decimal" value=""
                                            placeholder="Cost" autocomplete="one-time-code" />
                                        <label for="details_1_cost">Cost</label>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light-danger" button-repeater-remove>
                                        <i class="ki-duotone ki-trash fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <button type="button" class="btn btn-sm btn-light-primary"
                                    button-repeater-variation-create>
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    Add another variation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush">
                    <div class="card-header border-0">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('Item Codes') }}</h3>
                        </div>
                    </div>
                    <div class="card-body border-top p-9">
                        <div class="mb-10 fv-row">
                            <label for="item_codes" class="form-label">Add Item Codes</label>
                            <div class="d-flex flex-column gap-3" data-repeater-list>
                                <div class="input-group" data-id="1" data-repeater-item>
                                    <div class="form-floating">
                                        <input id="code_1_value" type="text" name="codes[1]" class="form-control"
                                            value="" placeholder="Unique Code" autocomplete="one-time-code" />
                                        <label for="code_1_value">Unique Code</label>
                                    </div>
                                    <button type="button" class="btn btn-light-danger" button-repeater-remove>
                                        <i class="ki-duotone ki-trash fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <button type="button" class="btn btn-sm btn-light-primary"
                                    button-repeater-code-create>
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                    Add another code
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('items.index') }}" class="btn btn-light me-2">
                        {{ __('Back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <script src="{{ asset('vendor/form-render/create.js') }}"></script>

        <script>
            const handleInitInputMaskNumber = () => {
                Inputmask("integer", {
                    "rightAlignNumerics": false
                }).mask(`.input-number-integer`);

                Inputmask("decimal", {
                    "rightAlignNumerics": false,
                }).mask(`.input-number-decimal`);
            }

            handleInitCreate(`#form`, {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Item name is required",
                        },
                    },
                },
            });

            $(document).on('change', `[name="status"]`, function(e) {
                const itemStatusElement = $("#item_status");

                itemStatusElement.removeClass("bg-success bg-warning bg-danger");
                switch ($(this).val()) {
                    case "1":
                        itemStatusElement.addClass("bg-success");
                        break;
                    default:
                        itemStatusElement.addClass("bg-secondary");
                }
            });

            $(document).on('click', `[button-repeater-variation-create]`, function() {
                const dataList = $(this).closest('.fv-row').find(`[data-repeater-list]`);
                const dataLength = dataList.children().length;
                const dataId = dataLength && parseInt(dataList.children().last().data('id')) ?
                    parseInt(dataList.children().last().data('id')) + 1 : 1;

                $(`
                    <div class="form-group d-flex flex-wrap align-items-center gap-5" data-id="${dataId}" data-repeater-item>
                        <div
                            class="w-100 w-md-50px form-check form-switch form-check-custom form-check-success form-check-solid">
                            <input type="checkbox" name="details[${dataId}][status]" class="form-check-input w-50px cursor-pointer" value="1" checked="" />
                        </div>
                        <div class="form-floating w-100 w-md-200px">
                            <select id="detail_${dataId}_unit_of_measurement" name="details[${dataId}][unit_of_measurement]" class="form-select" data-control="select2" data-hide-search="true" data-placeholder="Select a variation" data-kt-initialized="1">
                                <option></option>
                                @forelse ($unitOfMeasurements as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <label for="detail_${dataId}_unit_of_measurement">Unit of Measurement</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" id="detail_${dataId}_quantity" name="details[${dataId}][quantity]" class="form-control mw-100 w-200px input-number-integer" placeholder="Quantity" autocomplete="one-time-code" />
                            <label for="detail_${dataId}_quantity">Quantity</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" id="detail_${dataId}_cost" name="details[${dataId}][cost]"  class="form-control mw-100 w-200px input-number-decimal" placeholder="Cost" autocomplete="one-time-code" />
                            <label for="detail_${dataId}_cost">Cost</label>
                        </div>
                        <button type="button" class="btn btn-sm btn-light-danger" button-repeater-remove>
                            <i class="ki-duotone ki-trash fs-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            Remove
                        </button>
                    </div>
                `).appendTo(dataList);

                $(`[name="details[${dataId}][unit_of_measurement]"]`).select2({
                    minimumResultsForSearch: 1 / 0
                });

                handleInitInputMaskNumber();
            });

            $(document).on('click', `[button-repeater-code-create]`, function() {
                const dataList = $(this).closest('.fv-row').find(`[data-repeater-list]`);
                const dataLength = dataList.children().length;
                const dataId = dataLength && parseInt(dataList.children().last().data('id')) ?
                    parseInt(dataList.children().last().data('id')) + 1 : 1;

                $(`
                    <div class="input-group" data-id="${dataId}" data-repeater-item>
                        <div class="form-floating">
                            <input type="text" id="code_${dataId}_value" name="codes[${dataId}]" class="form-control" value="" placeholder="Unique Code" autocomplete="one-time-code" />
                            <label for="code_${dataId}_value">Unique Code</label>
                        </div>
                        <button type="button" class="btn btn-light-danger" button-repeater-remove>
                            <i class="ki-duotone ki-trash fs-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            Remove
                        </button>
                    </div>
                `).appendTo(dataList);
            });

            $(document).on('click', '[button-repeater-remove]', function() {
                const thisRow = $(this).closest(`[data-repeater-item]`);

                $.confirm({
                    theme: themeMode,
                    title: 'Confirm!',
                    content: `Do you want to remove this item?`,
                    type: 'orange',
                    autoClose: 'cancel|5000',
                    buttons: {
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn btn-sm btn-secondary',
                            keys: ['esc'],
                        },
                        destroy: {
                            text: 'Yes, Delete',
                            btnClass: 'btn btn-sm btn-danger',
                            keys: ['enter'],
                            action: async function() {
                                thisRow.remove();
                            }
                        },
                    }
                });
            });

            handleInitInputMaskNumber();
        </script>
    </x-slot>
</x-main-app-layout>
