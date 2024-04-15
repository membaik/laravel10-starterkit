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

$(document).on("click", `#button_email_edit_open`, async function () {
    handleChangeEmail();
});

$(document).on("click", `#button_email_cancel`, async function () {
    handleChangeEmail();
});

$(document).on("click", `#button_password_edit_open`, async function () {
    handleChangePassword();
});

$(document).on("click", `#button_password_cancel`, async function () {
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
}).on("core.form.valid", async function (e) {
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
        success: async function (res) {
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

            submitButton.prop("disabled", false);
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
        },
    });
});

FormValidation.formValidation(document.querySelector("#form_password"), {
    fields: {
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
                    compare: function () {
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
}).on("core.form.valid", async function (e) {
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
        success: async function (res) {
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

            submitButton.prop("disabled", false);
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
        },
    });
});
