@extends('backend.layout.root')
@section('title', Str::title($container->title))
@section('content')
    <div class="mb-5">
        <div id="filter_collapse" class="collapse" aria-labelledby="kt_accordion_1_header_1">
            <div class="shadow-sm card">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Filters</h5>
                    </div>
                    <div class="gap-4 card-toolbar d-flex">
                        <button load-latest-filters class="btn btn-light-primary btn-sm">
                            <i class="fas fa-filter-circle-dollar"></i>
                            Load Latest Filters
                        </button>
                        <button clear-filters class="btn btn-light-danger btn-sm">
                            <i class="fas fa-filter-circle-xmark"></i>
                            Clear Filters
                        </button>
                    </div>

                </div>
                <div class="card-body row gx-4 gy-4">

                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 form-group">
                        <label class="text-gray-400 form-label fs-7">By Province</label>
                        <select filter-by="province_id" class="form-control form-select form-select-sm"
                            data-control="select2">
                            <option value="-1">Hepsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header">
            <x-datatable-toolbar :createUrl="route('user.create')" />
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="pt-0 card-body">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead class="text-gray-400 text-start fw-bold fs-7 text-uppercase gs-0">
                    </thead>
                    <tbody class="text-gray-600 fw-semibold"></tbody>
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Products-->
    <x-crud-ajax />
@endsection
@section('js')
    <script>
        let _dt;
        $(document).ready(function() {
            _dt = new HDataTable("table", {
                deleteUrl: "{{ route($container->page . '.delete') }}",
                ajax: {
                    url: "{{ route('team.index', ['datatable' => 'true']) }}",
                    type: "GET",
                    data: (d) => {
                        let filters = {};

                        $('[filter-by]').each(function() {
                            filters[$(this).attr('filter-by')] = $(this).val()
                        })

                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            _method: "POST",
                        }, {
                            filter_by: filters ?? {}
                        });
                    }
                },
                columns: [{
                        title: '#',
                        name: 'id',
                        data: 'id',
                        className: 'w-40px text-start'
                    },
                    {
                        title: 'Name',
                        name: 'name',
                        data: 'name'
                    },
                    {
                        title: 'Province',
                        name: 'province.name',
                        data: 'province.name'
                    },
                    {
                        render: function(data, type, row) {
                            return `
                            <div class="flex-wrap gap-2 d-flex flex-row-fluid justify-content-end">
                                <a class="btn btn-icon btn-sm btn-success" ajax-edit hd-tooltip="Edit"><i class="fas fa-pencil"></i></a>
                                <a hd-datatable-delete="__replace_id" class="btn btn-icon btn-sm btn-danger" hd-tooltip="Delete"><i class="fas fa-trash"></i></a>
                            </div>
                        `.replaceAll('__replace_id', row.id);
                        },
                        title: '-',
                        className: 'text-end'
                    }
                ]
            });
        });
    </script>
@endsection
