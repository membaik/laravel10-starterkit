const checkboxSelectAll = $(`[checkbox-select-all]`);
checkboxSelectAll.on("change", function () {
    const checkboxList = $(this).closest(".col-sm-6").find(`[type="checkbox"]`);
    checkboxList.prop("checked", this.checked);
});

$(document).on("change", `[checkbox-select-item]`, function () {
    const checkboxList = $(this)
        .closest("[list-group]")
        .find(`[type="checkbox"]`);
    let isSelectedAll = true;
    checkboxList.each(function () {
        if ($(this).is(":checked") === false) {
            $(this)
                .closest(".col-sm-6")
                .find(`[checkbox-select-all]`)
                .prop("checked", false);

            isSelectedAll = false;
        }
    });

    if (isSelectedAll) {
        $(this)
            .closest(".col-sm-6")
            .find(`[checkbox-select-all]`)
            .prop("checked", true);
    }
});
