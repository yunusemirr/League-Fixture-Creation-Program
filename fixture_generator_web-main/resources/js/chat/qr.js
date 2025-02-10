// import { Loading } from "notiflix";

import axios from "axios";
import Notiflix from "notiflix";
$(document).ready(function () {
    Notiflix.Block.pulse("#qr-body", {
        svgColor: "green"
    })
})


function requestQR(){
    Notiflix.Block.pulse("#qr-body")
    axios.get(route('chat.qr'), {
        params: {
            ajax: true
        }
    })
    .then(response => {
        if(response.data?.status == true){
            Notiflix.Block.remove("#qr-body")

            //change img src on image loaded
            let image = new Image()
            console.log("saas")
            image.src = response.data?.data
            image.onload = function(){
                $("#qr-body img").attr("src", response.data?.data)
            }

            // $("#qr-body img").toggleClass("d-none").attr("src", response.data?.data)
        }
        else{
            window.location.reload()
        }
    })
}


setInterval(() => {
    requestQR()
}, 10000);
