$(document).ready(function () {

    const lessonModal = $("[modal-lesson-select]")

    const lessonSelector = lessonModal.find("[name=lesson_id]")
    const teacherSelector = lessonModal.find("[name=teacher_id]")

    const lessonParent = lessonModal.find("[lesson-parent]")
    const teacherParent = lessonModal.find("[teacher-parent]")

    function toggleTeacherSelector(){
        if(!lessonSelector.val() || lessonSelector.val() == ""){
            teacherParent.toggleClass("d-none", true)
        }

        const selected = lessonSelector.find("option:selected")
        const { teachers } = selected.data()

        teacherSelector.empty()
        teacherSelector.append(`<option value="">Seç</option>`)

        if(teachers && teachers.length > 0){
            teachers.forEach(element => {
                teacherSelector.append(`<option value="${element.id}">${element.name}</option>`)
            });
            teacherParent.toggleClass("d-none", false)
        }
    }

    lessonSelector.on("input", toggleTeacherSelector)

    lessonModal.on("click","[add-lesson-button]", function(e){
        if(lessonModal.calendar){
            const {start,end} = lessonModal
            const { color } = lessonSelector.find("option:selected").data()
            const event = {
                title: `${lessonSelector.find("option:selected").text()} - ${teacherSelector.find("option:selected").text()}`,
                start,
                end,
                eventOverlap: false,
                teacher_id: teacherSelector.val(),
                lesson_id: lessonSelector.val(),
                color: color,
            }
            lessonModal.calendar.addEvent(event)

            lessonModal.modal("hide")
            resetSelectorModal()
        }
    })

    lessonModal.on("hidden.bs.modal", resetSelectorModal)

    function resetSelectorModal(){
        lessonSelector.val("").change()
        toggleTeacherSelector()
        teacherSelector.empty()
    }

    function toggleSelectorModal(selection, calendar){
        const {start,end} = selection

        lessonModal.start = start
        lessonModal.end = end
        lessonModal.calendar = calendar
        lessonModal.modal("show")
        return lessonModal
    }

    window.toggleSelectorModal = toggleSelectorModal
});


