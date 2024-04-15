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
}).on("core.form.valid", async function (e) {
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
        success: async function (res) {
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
                        action: function () {
                            location.href = redirectUrl;
                        },
                    },
                },
            });
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
});
