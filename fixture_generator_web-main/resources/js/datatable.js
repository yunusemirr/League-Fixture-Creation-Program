export default class HDataTable{
    datatable = null;
    selector = null;
    tableEl = null;

    //add a constructor
    /**
     *
     * @param {*} selector
     * @param {object} params
     * @returns {DataTables}
     */
    constructor(selector, params){
        this.selector = selector;
        this.tableEl = $(selector);

        if(this.tableEl.length === 0){
            console.error("No table found with selector: " + selector);
            return;
        }

        if(typeof params.ajax === 'undefined'){
            params.ajax = {
                url: (new URLSearchParams(window.location.search)).set('datatable', true).toString(),
                type: 'POST',
                data: function(d){
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            }
        }
        if(typeof params.order == 'undefined')
            params.order = [];

        if(typeof params.drawCallback == 'undefined')
        {
            params.drawCallback = function(settings, json)
            {
                $('[data-toggle="tooltip"]').tooltip();
            }
        }

        params.orderCellsTo = true;
        params.fixedHeader = true;
        params.processing = true;
        params.serverSide = true;
        params.searchDelay = 5000;
        params.dom = "Btr<'row align-items-center'<'col-sm-4'l><'col-sm-4 text-center'i><'col-sm-4'p>>";

        for (const column of params.columns) {
            if(column.defaultContent === undefined)
                column.defaultContent = '-';
        }

        params.columns = [
            //add checkbox column
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta){
                    return `
                        <div class="d-flex flex-row gap-4 justify-content-center align-items-center my-auto">
                            <p class="text-muted my-auto">${row.DT_RowIndex}.</p>
                            <div class="form-check my-auto">
                                <input class="form-check-input" hd-dt-selector type="checkbox" />
                            </div>
                        </div>
                    `;
                },
                className: 'text-center'
            },
            ...params.columns
        ]
        params.order = [[1, 'desc']];
        params.select = {
            style: 'multi',
            selector: 'td:first-child input[type="checkbox"]'
        }
        params.scrollX = true;
        params.iDisplayLength = 50;

        this.datatable = $(selector).DataTable(params)

        this.datatable.on('draw.dt', function(){
            handleTooltip();
        })

        return this;
    }

    getDatatable(){
        return this.datatable;
    }

    getTableEl(){
        return this.tableEl;
    }
}
