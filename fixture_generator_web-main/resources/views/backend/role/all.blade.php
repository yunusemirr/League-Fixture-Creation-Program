@extends('backend.layout.root')
@section('title', Str::title($container->title)))
@section('content')
<!--begin::Products-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <x-datatable-toolbar :createUrl="route($container->page.'.create')" />
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="pt-0 card-body">
        <!--begin::Table-->
        <table class="table align-middle table-responsive table-row-dashed fs-6 gy-5">
            <thead class="text-gray-400 text-start fw-bold fs-7 text-uppercase gs-0">
            </thead>
            <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Products-->
@endsection
@section('js')
<script>
    let _dt;
    $(document).ready(function () {
        _dt = new HDataTable("table", {
            deleteUrl: "{{ route($container->page.'.delete') }}",
            ajax: {
                url: "{{ route($container->page.'.index', ['datatable' => 'true']) }}",
                type: "GET",
                data: (d) => {
                    return $.extend({}, d, {
                        _token: "{{ csrf_token() }}",
                        _method: "POST",
                    });
                }
            },
            columns: [
                { title:'#',name:'id',data:'id',className:'w-40px text-start'},
                { title:'{{ __('models.role.name') }}', name:'name', data:'name'},
                {
                    render: function(data, type, row){
                        return `
                            <div class="flex-wrap gap-2 d-flex flex-row-fluid justify-content-end">
                                @can ("{$container->page}.edit")
                                    <a href="{{ route("{$container->page}.edit", ['id' => '__replace_id']) }}" class="btn btn-icon btn-sm btn-success" hd-tooltip="Düzenle"><i class="fas fa-pencil"></i></a>
                                @endcan
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
