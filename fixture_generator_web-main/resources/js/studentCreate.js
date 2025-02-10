import axios from "axios";
import Notiflix from "notiflix"


//parent tc check and loader
$(document).on("click touch", "[hd-button=checkParentTc]", function () {
    let tc = $("input[name=parent_tc]")

    if(!tc?.val() || tc.val().length < 0){
        Notiflix.Report.failure("Alanları Kontrol Ediniz...", "Veli TC alanını kontrol ediniz...")
        return;
    }

    Notiflix.Loading.dots();

    axios({
        method: "GET",
        url: route('student.parent-ajax'),
        params: {
            tc: tc.val()
        },
    })
    .then(response => {
        if(response.status == 200 && response.data?.status == true){

            for (const key of ["name","surname","phone","email","job","address"]) {
                if($(`[name=parent_${key}]`).length)
                    $(`[name=parent_${key}]`)?.val(response?.data?.data[key])
            }

            $("[name=is_parent_checked]").val(true)
        }
        else{
            Notiflix.Report.failure("!", response?.data?.message || "Bu tc'li bir veli bulunamadı...");
        }
    })
    .catch(e => Notiflix.Report.failure('!', e?.message || "Bir hata oluştu"))
    .finally(() => Notiflix.Loading.remove())
});
