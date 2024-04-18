const handleInitCreate = (formId, formFields) => {
    FormValidation.formValidation(document.querySelector(`${formId}`), {
        fields: formFields,
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
};
