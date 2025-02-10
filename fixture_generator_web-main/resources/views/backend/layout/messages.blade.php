@if ($errors->any())
<div class="p-5 mb-10 border border-dashed alert alert-dismissible bg-light-danger border-danger d-flex flex-column flex-sm-row w-100">
    <i class="mb-5 ki-duotone ki-notification-bing fs-2hx text-danger me-4 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div class="d-flex flex-column pe-0 pe-sm-10 text-danger">
        <h5 class="mb-1">@lang('components.alerts.error')</h5>
        @foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
    </div>

    <button type="button" class="top-0 mb-5 position-absolute position-sm-relative m-sm-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
    </button>
</div>
@endif

@if (Session::has('error'))
<div class="p-5 mb-10 border border-dashed alert alert-dismissible bg-light-danger border-danger d-flex flex-column flex-sm-row w-100">
    <i class="mb-5 ki-duotone ki-notification-bing fs-2hx text-danger me-4 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div class="d-flex flex-column pe-0 pe-sm-10 text-danger">
        <h5 class="mb-1">@lang('components.alerts.error')</h5>
        <li>{{ Session::get('error') }}</li>
    </div>

    <button type="button" class="top-0 mb-5 position-absolute position-sm-relative m-sm-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
    </button>
</div>
@endif

@if (Session::has('success'))
<div class="p-5 mb-10 border border-dashed alert alert-dismissible bg-light-success border-success d-flex flex-column flex-sm-row w-100">
    <i class="mb-5 ki-duotone ki-notification-bing fs-2hx text-success me-4 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div class="d-flex flex-column pe-0 pe-sm-10 text-success">
        <h5 class="mb-1">@lang('components.alerts.success')</h5>
        <li>{{ Session::get('success') }}</li>
    </div>

    <button type="button" class="top-0 mb-5 position-absolute position-sm-relative m-sm-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
    </button>
</div>
@endif