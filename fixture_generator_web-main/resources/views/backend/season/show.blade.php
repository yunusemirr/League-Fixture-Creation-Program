@extends('backend.layout.root')
@section('title', Str::title($container->title))
@section('content')
	<div class="row g-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-center flex-row gap-4">
						<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative bg-primary">
							<img src="https://api.dicebear.com/9.x/shapes/svg?seed={{ $season->id }}" alt="image" />
						</div>
						<div class="d-flex flex-column gap-2">
							<h1>{{ $season->name }}</h1>
							<div class="d-flex flex-row gap-1">
                                <a class="btn btn-warning btn-sm" href="{{ route('season.hydrate', ['season' => $season->id]) }}">Generate Fixture</a>
								<a class="btn btn-info btn-sm" href="{{ route('season.final', ['season' => $season->id]) }}?p=1">Finish 1. Period</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('season.final', ['season' => $season->id]) }}">Finish Season</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold border-transparent">
						@foreach (['index' => 'Overview', 'fixture' => 'Fixture', 'matches' => 'Matches'] as $path_key => $path_name)
							<li class="nav-item mt-2">
								<a class="nav-link text-active-primary {{ $path == $path_key ? 'active' : '' }} me-10 ms-0 py-5" href="{{ route('season.show', ['path' => $path_key, 'season' => $season->id]) }}">
									{{ $path_name }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>

		@switch($path)
			@case('index')
				@include('backend.season.components.index')

				@break
			@case('fixture')
				@include('backend.season.components.fixture')

				@break
			@case('matches')
				@include('backend.season.components.matches')

				@break
			@default
		@endswitch
	</div>
@endsection
