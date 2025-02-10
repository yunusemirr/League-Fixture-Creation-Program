@extends('backend.layout.root')
@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Ooooops.</h2>
        <div class="card-toolbar">
            <a href="{{ route('panel.show') }}" class="btn btn-light-info">
                <i class="fas fa-backward-fast"></i>
                Panele Dön
            </a>
        </div>
    </div>
    <div class="card-body align-items-center justify-content-center d-flex flex-column">
        <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">
            Oops!
        </h1>
        <div class="fw-semibold fs-6 text-gray-500 mb-7">
            We can't find that page.
        </div>
        <img src="{{ asset('assets/media/auth/404-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="">
        <img src="{{ asset('assets/media/auth/404-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="">
        <a href="{{ route('panel.show') }}" class="btn btn-light-info">
            <i class="fas fa-backward-fast"></i>
            Panele Dön
        </a>
    </div>

</div>
@endsection
