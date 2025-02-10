@extends('backend.layout.root')

@section('content')
<div class="row">
	<div class="shadow-sm card">
		<div class="card-header">
			<h3 class="card-title">ROL DÜZENLE</h3>
            <div class="card-toolbar">
                <a href="{{ route("{$container->page}.index") }}" class="btn btn-sm btn-light-info">
                    <i class="fas fa-arrow-left"></i>
                    @lang('components.crud.go_back_list')
                </a>
            </div>
		</div>
		<!--begin::Form-->
		<form method="POST" action="{{ $data?->id ? route($container->page.'.update', ['id' => $data->id]) : route('role.store') }}" enctype="multipart/form-data">
			@csrf
			<div class="card-body">

				<div class="mb-5 row">

					<div class="mb-5 col-md-3">
						<label class="form-label" for="name">Adı <span class="text-danger">*</span></label>
					</div>
					<div class="mb-5 col-md-9">
						<input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Adı" name="name" id="name" required value="{{ old('name') ? old('name') : $data->name }}" />
						@error('name')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-5 col-md-3">
						<label class="form-label" for="permissions">İzinler <span class="text-danger text-small">*</span></label>
					</div>
					<div class="mb-5 col-md-9">
						<div class="row gy-4">
							@foreach ($routes as $group_route)
							<div class="col-md-4">
								<h5 class="text-danger">
									{{ $group_route->first()->category_name }}
								</h5>
								<div class="frame-wrap demo">
									<div class="demo">
										@foreach ($group_route->sortBy('route_name') as $route)
										<div class="mb-5">
											<div class="form-check form-check-custom form-check-solid" >
												<input type="checkbox" class="form-check-input" name="permissions[]" id="permissions-{{ $route->id }}" @checked($data->id && $data?->hasPermissionTo($route->route_name)) value="{{ $route->route_name }}"  data-bs-toggle="tooltip" title="{{ $route->route_name }}">
												<label class="form-check-label" for="permissions-{{ $route->id }}">{{ $route->name }}</label>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>

				</div>

			</div>
			<div class="card-footer">
                <div class="flex-row gap-2 d-flex justify-content-end">
                    <button type="submit" class="mb-2 btn btn-sm btn-light-primary">
                        <i class="fas fa-save"></i>
                        @lang('components.form.save')
                    </button>
                    <a href="{{ route("{$container->page}.index") }}" class="mb-2 btn btn-sm btn-light-danger">
                        @lang('components.form.cancel')
                    </a>
                </div>
            </div>
		</form>
		<!--end::Form-->
	</div>
</div>
@endsection
