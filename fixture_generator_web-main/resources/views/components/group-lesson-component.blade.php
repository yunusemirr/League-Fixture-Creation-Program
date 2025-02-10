<div modal-lesson-select class="modal fade" tabindex="-1" id="lesson_select_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">@lang('components.lesson_modal.title')</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" >
                    <i class="fas fa-times"></i>
                </div>
            </div>

            <div class="modal-body">
                <div class="row fw-row">

                    <div lesson-parent class="mb-4 col-12 row">
                        <div class="form-group col-10">
                            <label class="form-label">@lang('models.lesson.model_name')</label>
                            <select name="lesson_id" class="form-control form-select form-select-lg" data-control="select2" data-placeholder="@lang('components.form.select')" data-dropdown-parent="#lesson_select_modal">
                                <option value=""></option>
                                @foreach ($lessons as $lesson)
                                    <option data-color='{{ $lesson->color }}' data-teachers='@json($lesson->teachers)' value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div teacher-parent class="col-12 row">
                        <div class="form-group col-10">
                            <label class="form-label">@lang('models.lesson.teachers')</label>
                            <select name="teacher_id" class="form-control form-select form-select-lg" data-control="select2" data-placeholder="@lang('components.form.select')" data-dropdown-parent="#lesson_select_modal">
                                <option></option>
                            </select>
                        </div>
                        <div class="mt-auto col-2">
                            <button ajax-calendar disabled type="button" data-bg-toggle="tooltip" title="Hocanın takvimini görüntüle" class="btn btn-primary btn-lg w-100 fs-4">
                                <i class="fas fa-calendar-week"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button add-lesson-button class="btn btn-primary">Ekle</button>
            </div>
        </div>
    </div>
</div>


@push('js')
    @vite(['resources/js/groupLesson.js'])
@endpush
