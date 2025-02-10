
<div>
    <div @foreach ($urls as $key => $url ) data-{{$key}}="{{$url}}" @endforeach class="modal fade ajax-modal" id="ajax-modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="rounded modal-content">
                <!--begin::Modal header-->
                <div class="pb-0 border-0 modal-header justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->

                <!--begin::Modal body-->
                <div class="px-10 pt-0 modal-body scroll-y px-lg-15 pb-15">
                    <!--begin:Form-->
                    <!--begin::Heading-->
                    <div class="text-center border-b mb-13 border-danger dashed-v">
                        <!--begin::Title-->
                        <h1 class="mb-3">{{ $controller->getContainer()->title ?? '' }}</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->

                    <div class="mt-2 mb-2">
                        {!! form($form) !!}
                    </div>

                    <!--begin::Actions-->
                    {{-- <div class="text-center">
                        <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">
                            İptal
                        </button>

                        <button data-modal-submit class="btn btn-primary">
                            <span class="indicator-label">
                                Kaydet
                            </span>
                        </button>
                    </div> --}}
                    <!--end::Actions-->
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</div>


@push('scripts')
<script>

    $(document).on("submit","form.ajax-form", function (e) {
        e.preventDefault()
        const modal = $(this).parents('.ajax-modal');
        const form = modal.find('form.ajax-form');
        const formData = new FormData(form[0])
        const dataTable = $('[datatable]');
        toggleBlock('form.ajax-form')

        const { type:form_type, store:store_url, update:update_url } = modal.data();

        const formFields = Object.fromEntries(formData);

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: formFields,
            dataType: "json",
            success: function (response) {
                const { status, message } = response;
                console.log(status)
                if(status == false){
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: message,
                    })
                }
                else{
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: message,
                    })

                    modal.modal('hide');
                    dataTable.DataTable().ajax.reload();
                }

                toggleBlock('form.ajax-form')
            },
            error: function (response) {
                const { status, message } = response.responseJSON;

                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: message,
                })

                toggleBlock('form.ajax-form')
            }
        });
    });

    $(document).on("click","[data-modal-submit]", function (e) {

    });

</script>
@endpush