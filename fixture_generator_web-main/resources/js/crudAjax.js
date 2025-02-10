$(document).ready(function () {
    let selects = $("[data-control=select2][custom-inputer]")
    $.each(selects, function (i, e) {
        $(e).select2({
            tags: true,
            allowClear: true,
        })
    });

    $(document).on("input", ".is-invalid", function () {
        $(this).removeClass("is-invalid");
    });

    function prepareForm(form){
        let selects = form.find("select")
        $.each(selects, function (i, e) {
            $(e).val("").trigger("change")
        });
    }

    $(document).on("click", "[ajax-create]", function (e) {
        e.preventDefault()

        const href = $(this).attr("href")
        const modal = $("#ajax-modal")
        const form = modal.find("form.ajax-form")
        const storeUrl = modal.data("store")
        modal.attr("data-type", "store")

        if (modal.length > 0 && storeUrl != undefined && storeUrl != null) {
            modal.modal("show")
        }
        else {
            window.location.href = href
        }
        clearModalForm()
        prepareForm(form)
        form.attr("action", storeUrl)
    })

    $(document).on("click", "[ajax-edit]", function (e) {
        //this click is the datatable row edit button retrieve all data from it
        e.preventDefault()
        const href = $(this).attr("href")
        const modal = $("#ajax-modal")
        const form = modal.find("form.ajax-form")
        modal.attr("data-type", "update")
        clearModalForm()
        modal.modal("show")

        if (modal.length < 0 && form.length < 0)
            window.location.href = href

        if (_dt == undefined || _dt == null)
            window.location.href = href

        /**
         * @type DataTables.JQueryDataTables datatable
         */
        const datatable = _dt.getDatatable()
        const row = $(this).closest("tr")
        const dataRow = datatable.rows(row).data()[0]
        const formData = new FormData(form[0])
        const entries = Object.fromEntries(formData.entries())
        const updateUrl = modal.data("update")

        if (dataRow.id == undefined || dataRow.id == null || updateUrl == undefined || updateUrl == null)
            window.location.href = href

        for (const key in entries) {
            if (dataRow[key] != undefined) {
                let el = $(form).find(`[name=${key}]`)
                if (el.length > 0) {

                    if(el.attr("type") == "file")
                        continue

                    //check if element is select input
                    if (el[0].tagName == "SELECT") {
                        console.log(dataRow)
                        let options = $(el).find("option")
                        let option = $(options).filter(function (i, e) {
                            return $(e).attr("value") == dataRow[key]
                        }
                        )
                        if (option.length > 0) {
                            el.val($(option).val()).trigger("change")
                        }
                    }
                    else {
                        $(el).val(dataRow[key])
                    }

                }
            }
        }

        const formAction = new URL(updateUrl)
        formAction.searchParams.set("id", dataRow.id)
        form.attr("action", formAction.toString())
    });
});
function clearModalForm(){
    let inputs = $("#ajax-modal").find("form.ajax-form").find("input, select, textarea")
    $.each(inputs, function (i, e) {
        if ($(e).attr("name") == "_token")
            return

        $(e).parents(".form-group").find(".text-danger").remove()
        $(e).val("").trigger("change").closest(".text-danger").remove()
    })
}
//on modal close reset form
$(document).on("hidden.bs.modal", "#ajax-modal", function () {
    clearModalForm()
})