@extends('backend.layout.root')

@section('content')
<div class="">
    <form method="POST" action="{{ route('setting.save') }}">@csrf
        <div class="row">
            <div class="col-12 card card-dashed shadow-sm mb-2">
                <div class="card-header">
                    <h2 class="card-title">İçerik Ayarları</h2>
                    <div class="card-toolbar">
                        <div data-bs-toggle="collapse" data-bs-target="#hd_collapse_1" class=" btn btn-light-info btn-sm"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
                <div class="collapse show" id="hd_collapse_1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="form-label fw-bold">Kayıt Olma Yazısı</label>
                                <textarea class="form-control mh-100px overflow-auto" name="setting[register_content]" id="setting_register_content" placeholder="Giriniz...">{{ $setting?->where('key', 'register_content')?->first()?->value }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 card card-dashed shadow-sm mb-2">
                <div class="card-header">
                    <h2 class="card-title">Birebir Ayarları</h2>
                    <div class="card-toolbar">
                        <div data-bs-toggle="collapse" data-bs-target="#hd_collapse_2" class=" btn btn-light-info btn-sm"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
                <div class="collapse show" id="hd_collapse_2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="form-label fw-bold">Ders Başı Max Birebir</label>
                                <input value="{{ $setting?->where('key', 'tutor_count')?->first()?->value }}" class="form-control" type="number" name="setting[tutor_count]" placeholder="Giriniz...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 p-0">
                <div class="btn-group btn-group-lg float-end">
                    <a href="{{ route("show") }}" class="btn btn-light-warning">
                        <i class="fas fa-times"></i> İptal
                    </a>
                    <button class="btn btn-light-success">
                        <i class="fas fa-save"></i> Kaydet
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@section('css')
<style>
    .ck-editor__editable {
        height: 180px; /* Adjust the height as per your requirements */
        overflow: auto; /* or overflow: scroll; */
    }
</style>
@endsection

@push('js')
    <script src="/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script>
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#setting_register_content'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
