console.log("trialExamResult.js");
const modal = $("#hd_trial_result_modal")
const dropzone = modal.find("#hd_dropzone")


let openModal = (trial_id, student_id) => {


    //if dropzone initialized, destroy it
    if (dropzone.hasClass("dz-clickable")){
        Dropzone.forElement("#hd_dropzone").destroy();
    }

    //initialize dropzone
    Dropzone.autoDiscover = false;
    let myDropzone = new Dropzone("#hd_dropzone", {
        url: route("trial_exam.upload", {trialExam: trial_id, student: student_id}),
        maxFiles: 10,
        maxFilesize: 2,
        acceptedFiles: ".png,.jpeg,.jpg",
        addRemoveLinks: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function () {
            this.on("addedfile", function (file) {
                console.log("File uploaded");
                console.log(file);
            });
            this.on("success", function (file, response) {
                console.log("File uploaded successfully");
                console.log(response);
            });
        }
    });

    modal.modal("show");
}
window.openModal = openModal;

$(document).on("click","[result-clicker]", function () {
    let {trialId, studentId} = $(this).data();
    openModal(trialId, studentId);
});
