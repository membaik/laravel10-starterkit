<?php
$title = __('Edit :name', ['name' => __('Security')]);
$breadcrumbs = [
    [
        'name' => __('Profile'),
        'url' => route('profile.index'),
    ],
    [
        'name' => __('Edit'),
        'url' => route('profile.edit'),
    ],
    [
        'name' => __('Security'),
        'url' => route('profile.edit.security'),
    ],
];
?>

<x-main-app-layout :title="$title" :breadcrumbs="$breadcrumbs">
    <div id="kt_app_content_container" class="app-container mt-5 mt-lg-9">
        <!--begin::Header-->
        @include('profile.partials.header')
        <!--end::Header-->

        <!--begin::Sign-in Method-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ __('Sign-in Method') }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                @can('auth.edit-email')
                    <!--begin::Email Address-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="div_email_show">
                            <div class="fs-6 fw-bold mb-1">{{ __('Email Address') }}</div>
                            <div class="fw-semibold text-gray-600">{{ auth()->user()->email }}</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Edit-->
                        <div id="div_email_edit" class="flex-row-fluid d-none">
                            <!--begin::Form-->
                            <form id="form_email" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('profile.update.email') }}">
                                @method('PUT')

                                <div class="row mb-6">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="fv-row mb-0">
                                            <label for="email" class="form-label fs-6 fw-bold mb-3">
                                                {{ __('Enter New Email Address') }}
                                            </label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg form-control-solid"
                                                value="{{ auth()->user()->email }}" placeholder="{{ __('Email Address') }}"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="fv-row mb-0">
                                            <label for="password" class="form-label fs-6 fw-bold mb-3">
                                                {{ __('Confirm Password') }}
                                            </label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" id="button_email_submit" class="btn btn-primary me-2 px-6">
                                        {{ __('Update :name', ['name' => __('Email')]) }}
                                    </button>
                                    <button type="button" id="button_email_cancel"
                                        class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->
                        <!--begin::Action-->
                        <div class="ms-auto">
                            <button id="button_email_edit_open" class="btn btn-light btn-active-light-primary">
                                {{ __('Change Email') }}
                            </button>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Email Address-->
                @endcan

                @can('auth.edit-password')
                    @can('auth.edit-email')
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-6"></div>
                        <!--end::Separator-->
                    @endcan
                    <!--begin::Password-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="div_password_show">
                            <div class="fs-6 fw-bold mb-1">{{ __('Password') }}</div>
                            <div class="fw-semibold text-gray-600">************</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Edit-->
                        <div id="div_password_edit" class="flex-row-fluid d-none">
                            <!--begin::Form-->
                            <form id="form_password" onsubmit="return false" novalidate="novalidate" class="form"
                                data-url-action="{{ route('profile.update.password') }}">
                                @method('PUT')

                                <div class="row mb-1">
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="current_password" class="form-label fs-6 fw-bold mb-3">
                                                {{ __('Current Password') }}
                                            </label>
                                            <input type="password" id="current_password" name="current_password"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="new_password" class="form-label fs-6 fw-bold mb-3">
                                                {{ __('New Password') }}
                                            </label>
                                            <input type="password" id="new_password" name="password"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="password_confirmation" class="form-label fs-6 fw-bold mb-3">
                                                {{ __('Confirm New Password') }}
                                            </label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                class="form-control form-control-lg form-control-solid"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text mb-5">
                                    {{ __('Password Must Be At Least :requires', ['requires' => strtolower(__('8 Character')) . ' ' . strtolower(__('And')) . ' ' . strtolower(__('Contain Symbols'))]) }}
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2 px-6">
                                        {{ __('Update :name', ['name' => __('Password')]) }}
                                    </button>
                                    <button type="button" id="button_password_cancel"
                                        class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->
                        <!--begin::Action-->
                        <div class="ms-auto">
                            <button id="button_password_edit_open" class="btn btn-light btn-active-light-primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Password-->
                @endcan
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Sign-in Method-->
    </div>

    <x-slot name="script">
        <script>
            const handleChangeEmail = () => {
                let a = document.getElementById("button_email_edit_open");
                let b = document.getElementById("div_email_show");
                let c = document.getElementById("div_email_edit");

                a.classList.toggle("d-none");
                b.classList.toggle("d-none");
                c.classList.toggle("d-none");
            };

            const handleChangePassword = () => {
                let a = document.getElementById("button_password_edit_open");
                let b = document.getElementById("div_password_show");
                let c = document.getElementById("div_password_edit");

                a.classList.toggle("d-none");
                b.classList.toggle("d-none");
                c.classList.toggle("d-none");
            };

            $(document).on("click", `#button_email_edit_open`, async function() {
                handleChangeEmail();
            });

            $(document).on("click", `#button_email_cancel`, async function() {
                handleChangeEmail();
            });

            $(document).on("click", `#button_password_edit_open`, async function() {
                handleChangePassword();
            });

            $(document).on("click", `#button_password_cancel`, async function() {
                handleChangePassword();
            });

            FormValidation.formValidation(document.querySelector("#form_email"), {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "The value is not a valid email address",
                            },
                            notEmpty: {
                                message: "Email address is required",
                            },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required",
                            },
                            stringLength: {
                                min: 8,
                                message: "The password must be more than 8 characters long",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "is-invalid",
                        eleValidClass: "is-valid",
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                },
            }).on("core.form.valid", async function(e) {
                const form = $(e.formValidation.form);
                const actionUrl = form.data("url-action");
                const submitButton = form.find('[type="submit"]');

                submitButton.prop("disabled", true);
                await new Promise((resolve) => setTimeout(resolve, 1000));

                await $.ajax({
                    url: `${actionUrl}`,
                    type: "POST",
                    data: new FormData(form[0]),
                    enctype: "multipart/form-data",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: async function(res) {
                        if (res.meta?.success) {
                            $.confirm({
                                theme: themeMode,
                                title: "Success!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "green",
                                autoClose: "close|5000",
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {
                                            window.location.reload();
                                        },
                                    },
                                },
                            });
                        } else {
                            $.confirm({
                                theme: themeMode,
                                title: "Oops!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "red",
                                backgroundDismiss: true,
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {},
                                    },
                                },
                            });
                        }

                        submitButton.prop("disabled", false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const res = jQuery.parseJSON(jqXHR.responseText);
                        $.confirm({
                            theme: themeMode,
                            title: "Oops!",
                            content: `${
                                res.meta?.message ??
                                "Sorry, looks like there are some errors detected, please try again."
                            }`,
                            type: "red",
                            backgroundDismiss: true,
                            buttons: {
                                close: {
                                    text: "Close",
                                    btnClass: "btn btn-sm btn-secondary",
                                    keys: ["enter", "esc"],
                                    action: function() {},
                                },
                            },
                        });

                        submitButton.prop("disabled", false);
                    },
                });
            });

            FormValidation.formValidation(document.querySelector("#form_password"), {
                fields: {
                    current_password: {
                        validators: {
                            notEmpty: {
                                message: "Current Password is required",
                            },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "New Password is required",
                            },
                        },
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: "Confirm Password is required",
                            },
                            identical: {
                                compare: function() {
                                    return document.getElementById("new_password").value;
                                },
                                message: "The password and its confirm are not the same",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "is-invalid",
                        eleValidClass: "is-valid",
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                },
            }).on("core.form.valid", async function(e) {
                const form = $(e.formValidation.form);
                const actionUrl = form.data("url-action");
                const submitButton = form.find('[type="submit"]');

                submitButton.prop("disabled", true);
                await new Promise((resolve) => setTimeout(resolve, 1000));

                await $.ajax({
                    url: `${actionUrl}`,
                    type: "POST",
                    data: new FormData(form[0]),
                    enctype: "multipart/form-data",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: async function(res) {
                        if (res.meta?.success) {
                            $.confirm({
                                theme: themeMode,
                                title: "Success!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "green",
                                autoClose: "close|5000",
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {
                                            window.location.reload();
                                        },
                                    },
                                },
                            });
                        } else {
                            $.confirm({
                                theme: themeMode,
                                title: "Oops!",
                                content: `${res.meta?.message ?? ""}`,
                                type: "red",
                                backgroundDismiss: true,
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function() {},
                                    },
                                },
                            });
                        }

                        submitButton.prop("disabled", false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const res = jQuery.parseJSON(jqXHR.responseText);
                        $.confirm({
                            theme: themeMode,
                            title: "Oops!",
                            content: `${
                                res.meta?.message ??
                                "Sorry, looks like there are some errors detected, please try again."
                            }`,
                            type: "red",
                            backgroundDismiss: true,
                            buttons: {
                                close: {
                                    text: "Close",
                                    btnClass: "btn btn-sm btn-secondary",
                                    keys: ["enter", "esc"],
                                    action: function() {},
                                },
                            },
                        });

                        submitButton.prop("disabled", false);
                    },
                });
            });
        </script>
    </x-slot>
</x-main-app-layout>
