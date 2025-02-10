@extends('backend.layout.master')

@push('root')
<div class="d-flex flex-column flex-root">
    <div class="flex-row page d-flex flex-column-fluid">
        @include('backend.layout.aside')
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('backend.layout.header')
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="container-xxl" id="kt_content_container">
                    @include('backend.layout.messages')
                    @yield('content')
                    @stack('content')
                </div>
            </div>
            @include('backend.layout.footer')
        </div>
    </div>
</div>
@endpush

@push('js')
    @vite('resources/js/app.js')
@endpush
