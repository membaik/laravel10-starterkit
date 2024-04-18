<x-main-guest-auth-layout>
    <x-slot name="title">Login</x-slot>

    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <!--begin::Form-->
        <form id="form" class="form w-100" data-url-action="{{ route('login') }}"
            data-url-redirect="{{ url()->previous() }}" onsubmit="return false">

            <!--begin::Heading-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                <!--end::Title-->
            </div>
            <!--begin::Heading-->

            <!--begin::Input group-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" name="email" class="form-control bg-transparent"
                    placeholder="{{ __('Email') }}" autocomplete="one-time-code" />
                <!--end::Email-->
            </div>
            <!--end::Input group-->

            <div class="fv-row mb-5">
                <!--begin::Password-->
                <input type="password" name="password" class="form-control bg-transparent"
                    placeholder="{{ __('Password') }}" autocomplete="one-time-code" />
                <!--end::Password-->
            </div>
            <!--end::Input group-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-0">
                <div></div>

                @if (Route::has('password.request'))
                    <!--begin::Link-->
                    <a href="{{ route('password.request') }}" class="link-primary">
                        Forgot Password?
                    </a>
                    <!--end::Link-->
                @endif
            </div>
            <!--end::Wrapper-->

            <!--begin::Input group-->
            <div class="fv-row mb-5">
                <div class="form-check form-check-custom form-check-sm">
                    <input type="checkbox" id="remember_me" name="remember" class="form-check-input" />
                    <label class="form-check-label" for="remember_me">
                        {{ __('Remember me') }}
                    </label>
                </div>
            </div>
            <!--end::Input group-->

            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Sign In</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->

            @if (Route::has('register'))
                <!--begin::Sign up-->
                <div class="text-gray-500 text-center fw-semibold fs-6">
                    Not a Member yet?
                    <a href="{{ route('register') }}" class="link-primary">
                        Sign up
                    </a>
                </div>
                <!--end::Sign up-->
            @endif
        </form>
        <!--end::Form-->
    </div>

    <x-slot name="script">
        <script>
            FormValidation.formValidation(document.querySelector("#form"), {
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
                const redirectUrl = form.data("url-redirect");
                const submitButton = form.find('[type="submit"]');

                submitButton.prop("disabled", true);
                submitButton.attr("data-kt-indicator", "on");
                await new Promise((resolve) => setTimeout(resolve, 2000));

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
                        $.confirm({
                            theme: themeMode,
                            title: "Success!",
                            content: `You have successfully logged in.`,
                            type: "green",
                            autoClose: "close|5000",
                            buttons: {
                                close: {
                                    text: "Close",
                                    btnClass: "btn btn-sm btn-secondary",
                                    keys: ["enter", "esc"],
                                    action: function() {
                                        location.href = redirectUrl;
                                    },
                                },
                            },
                        });
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
                        submitButton.removeAttr("data-kt-indicator");
                    },
                });
            });
        </script>
    </x-slot>
</x-main-guest-auth-layout>
