

$(document).on("click touch", "[ajax-check-user]", function (e) {
    e.preventDefault();

    const url = route("user.ajax_check")
    const search = $(this).attr("ajax-check-user");
    const value = $(this).parents(`.form-group`).find(`[name=${search}]`).val();

    $.ajax({
        url: url,
        method: "GET",
        data: {
            search: search,
            value: value
        },
        success: function (response) {
            console.log(response);
        }
    })
});