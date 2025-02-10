function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        data.start = 0;
        data.length = 322333;
        dt.one('preDraw', function (e, settings) {
            if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            setTimeout(dt.ajax.reload, 0);
            return false;
        });
    });
    dt.ajax.reload();
}
var handleSearch = () => {
    const datatable = _dt.getDatatable();

    const filterSearch = document.querySelector('[hd-dt-search]');
    filterSearch.addEventListener('keyup', function (e) {
        datatable.search(e.target.value).draw();
    });
}
var handleButton = function(){
    const documentTitle = 'Humbldump Report';
    if(typeof _dt === undefined ){
        return;
    }
    console.log('init datatabletools')

    const datatable = _dt.getDatatable();
    if(datatable.buttons().length === 0){
        return;
    }
    datatable.buttons().container().hide().appendTo($('#hd_export_menu'));

    const exportButtons = document.querySelectorAll('#hd_export_menu [hd-export-button]');
    exportButtons.forEach(exportButton => {
        exportButton.addEventListener('click', e => {
            e.preventDefault();

            // Get clicked export value
            const exportValue = e.target.getAttribute('hd-export-button');
            const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

            // Trigger click event on hidden datatable export buttons
            target.click();
        });
    });

}

/**
 *
 * @param {Array<string>} ids
 * @returns
 */
var deleteRecords = function (ids){
    const datatable = _dt.getDatatable()
    const url = datatable?.context[0]?.oInit?.deleteUrl
    if(url == undefined || url == null){
        return;
    }

    Swal.fire({
        title: 'Emin misin?',
        text: `${ids.length} kayıt silinecek!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Hayır, vazgeç!'
    }).then(result => {
        if(result.isConfirmed){
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    id: ids,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    datatable.ajax.reload()
                }
            });
        }
    })


}

$(document).ready(function () {
    if(typeof _dt === 'undefined' ){
        return;
    }

    handleButton()
    handleSearch()

    $(document).on("click","[hd-dt-selector-all]", function () {
        $("input[hd-dt-selector]").trigger("click");
    });

    $(document).on("click", "[hd-datatable-delete]", function () {
        const ids = [
            $(this).attr('hd-datatable-delete')
        ]
        deleteRecords(ids)
    });

    $(document).on("click", "[hd-dt-button]", function () {
        const tool = $(this).attr('hd-dt-button')

        if(tool == "delete"){
            //get list of selected row ids from datatable
            const datatable = _dt.getDatatable()
            let selecteds = datatable.rows({selected: true}).data().toArray()
            if(selecteds.length == 0){
                Swal.fire({
                    title: 'Hata!',
                    text: 'Lütfen silmek istediğiniz kayıtları seçiniz!',
                    icon: 'error',
                    confirmButtonText: 'Tamam'
                })
                return;
            }
            deleteRecords(selecteds.map(row => row.id))
        }
    });
});
