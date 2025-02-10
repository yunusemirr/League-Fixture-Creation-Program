<!--begin::Image input-->
<div {{ $attributes }}>
    <div class="image-input image-input-circle" data-kt-image-input="true" style="background-image: url(/assets/media/svg/avatars/blank.svg)">
        <!--begin::Image preview wrapper-->
        <div class="image-input-wrapper w-150px h-150px" style="background-image: url('{{ (isset($initial) && $initial != '') ? $initial : asset('assets/media/svg/avatars/blank.svg') }}')"></div>
        <!--end::Image preview wrapper-->

        <!--begin::Edit button-->
        <label class="shadow btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body"
        data-kt-image-input-action="change"
        data-bs-toggle="tooltip"
        data-bs-dismiss="click"
        title="Resmi Değiştir">
            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
            <!--begin::Inputs-->
            <input type="file" name="{{ $name ?? '' }}" accept=".png, .jpg, .jpeg" />
            <input type="hidden" name="avatar_remove" />
            <!--end::Inputs-->
        </label>
        <!--end::Edit button-->

        <!--begin::Cancel button-->
        <span class="shadow btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body"
        data-kt-image-input-action="cancel"
        data-bs-toggle="tooltip"
        data-bs-dismiss="click"
        title="Değişikliği İptal Et">
            <i class="ki-outline ki-cross fs-3"></i>
        </span>
        <!--end::Cancel button-->

        {{-- <!--begin::Remove button-->
        <span class="shadow btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body"
        data-kt-image-input-action="remove"
        data-bs-toggle="tooltip"
        data-bs-dismiss="click"
        title="Remove avatar">
            <i class="ki-outline ki-cross fs-3"></i>
        </span>
        <!--end::Remove button--> --}}
    </div>
</div>
<!--end::Image input-->
