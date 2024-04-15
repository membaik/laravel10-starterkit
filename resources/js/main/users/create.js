var t = document.querySelector("#div_create_account_stepper");
var i = t.querySelector("#form_create_account");
var o = t.querySelector('[data-kt-stepper-action="submit"]');
var a = t.querySelector('[data-kt-stepper-action="next"]');
var r = new KTStepper(t);
var s = [];

r.on("kt.stepper.next", function (e) {
    var currentStepIndex = s[e.getCurrentStepIndex() - 1];
    if (currentStepIndex) {
        currentStepIndex.validate().then(function (t) {
            if ("Valid" == t) {
                e.goNext();
                KTUtil.scrollTop();
            }
        });
    } else {
        e.goNext();
        KTUtil.scrollTop();
    }
});

r.on("kt.stepper.previous", function (e) {
    e.goPrevious();
    KTUtil.scrollTop();
});

s.push(
    FormValidation.formValidation(i, {
        fields: {
            full_name: {
                validators: {
                    notEmpty: {
                        message: "Full name is required",
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
        },
    })
);

s.push(
    FormValidation.formValidation(i, {
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
                        message: "Password is required",
                    },
                },
            },
            password_confirmation: {
                validators: {
                    notEmpty: {
                        message: "Confirm Password is required",
                    },
                    identical: {
                        compare: function () {
                            return document.getElementById("password").value;
                        },
                        message:
                            "The password and its confirm are not the same",
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
        },
    })
);

s.push(
    FormValidation.formValidation(i, {
        fields: {},
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "is-invalid",
                eleValidClass: "is-valid",
            }),
        },
    })
);

o.addEventListener("click", function (e) {
    const form = $(this).closest("form");
    const actionUrl = form.data("url-action");
    const submitButton = $(this);

    s[s.length - 1].validate().then(async function (t) {
        if ("Valid" == t) {
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
                success: async function (res) {
                    if (res.meta?.success) {
                        $.confirm({
                            theme: themeMode,
                            title: "Success!",
                            content: `${res.meta?.message ?? ""}`,
                            type: "green",
                            buttons: {
                                index: {
                                    text: "Back to list",
                                    btnClass: "btn btn-sm btn-secondary",
                                    action: function () {
                                        window.location.replace(`${actionUrl}`);
                                    },
                                },
                                reCreate: {
                                    text: "Recreate",
                                    btnClass: "btn btn-sm btn-primary",
                                    action: function () {
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
                                    action: function () {},
                                },
                            },
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
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
                                action: function () {},
                            },
                        },
                    });

                    submitButton.prop("disabled", false);
                    submitButton.removeAttr("data-kt-indicator");
                },
            });
        } else {
            $.confirm({
                theme: themeMode,
                title: "Oops!",
                content:
                    "Sorry, looks like there are some errors detected, please try again.",
                type: "red",
                buttons: {
                    close: {
                        text: "Close",
                        btnClass: "btn btn-sm btn-secondary",
                        keys: ["enter", "esc"],
                        action: function () {
                            KTUtil.scrollTop();
                        },
                    },
                },
            });
        }
    });
});
