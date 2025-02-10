<!--begin::Card toolbar-->
<div class="flex-row py-0 d-flex card-toolbar col-12 gx-0 justify-content-between">
    <div class="">
        <div class="d-flex align-items-center position-relative">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <input type="text" hd-dt-search class="form-control form-control-solid w-250px ps-12" placeholder="Search" />
        </div>
    </div>
    <div class="flex-row gap-4 d-flex justify-content-end">
        <div>
            <button id="filterer_button" type="button" data-bs-toggle="collapse" data-bs-target="#filter_collapse" class="btn btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold">
                <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
                Filteler
            </button>
        </div>
        <div>
            {{-- <button type="button" class="btn btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="fas fa-wrench"></i>
                İşlemler
            </button> --}}

            @can ($container->page.'.delete')
                <div id="hd_dt_tools_menu" class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="px-3 menu-item">

                        <a href="#" class="px-3 menu-link" hd-dt-button="delete">
                            <i class="fas fa-trash me-2"></i>
                            @lang('components.dt.delete_selecteds')
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
            @endcan
        </div>
        <div>
            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="fas fa-file-alt"></i>
                Export
            </button>
            <div id="hd_export_menu" class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="px-3 menu-item">
                    <a href="#" class="px-3 menu-link" hd-export-button="copy">Copy to clipboard</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="px-3 menu-item">
                    <a href="#" class="px-3 menu-link" hd-export-button="excel">Export as Excel</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="px-3 menu-item">
                    <a href="#" class="px-3 menu-link" hd-export-button="csv">Export as CSV</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="px-3 menu-item">
                    <a href="#" class="px-3 menu-link" hd-export-button="pdf">Export as PDF</a>
                </div>
                <!--end::Menu item-->
            </div>
        </div>
        <a ajax-create href="{{ $createUrl }}" class="btn btn-primary">Create</a>
    </div>
</div>
<!--end::Card toolbar-->

@pushOnce('js')
    <script>
        $(document).ready(function () {
            let id = $("#filter_collapse")

            if(id.length <= 0)
                $("#filterer_button").remove()
            else{
                console.log(_dt)
                let storageName = "{{ str(request()->route()->getName()) }}"
                $(document).on("click","[load-latest-filters]", function () {
                    let filters = JSON.parse(localStorage.getItem(storageName))

                    if(!filters) return;

                    for (const filter of Object.keys(filters)) {
                        let el = $(`[filter-by=${filter}]`)
                        if(el.length == 0) continue;

                        el.val(filters[filter]).change()
                    }
                    _dt.getDatatable().ajax.reload()
                });

                $(document).on("click", "[clear-filters]", function () {
                    localStorage.removeItem(storageName)
                    $('[filter-by]').each(function (index, element) {
                        $(element).val(-1).change()
                    })
                    _dt.getDatatable().ajax.reload()
                });

                $(document).on("change","[filter-by]", function () {
                    let olds = localStorage.getItem(storageName)
                    let filters = olds ? JSON.parse(olds) : {}

                    const allFilters = $('[filter-by]')
                    allFilters.each(function () {
                        const filterName = $(this).attr('filter-by')
                        const filterValue = $(this).val()
                        filters[filterName] = filterValue
                    })

                    localStorage.setItem(storageName, JSON.stringify(filters))
                    _dt.getDatatable().ajax.reload()
                });
            }
        });
    </script>
@endPushOnce
