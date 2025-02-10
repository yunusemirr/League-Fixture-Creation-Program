import Alpine from "alpinejs";
import axios from "axios";
import Notiflix from "notiflix";

String.prototype.short = function(length = 20){
    return this.length > length ? this.substring(0,length) + "..." : this;
}

const chatBox = {
    fullScreen: false,
}

const chats = {
    searchInput : null,
    list: [],



    init(){
        Notiflix.Block.pulse(`#${this.$refs.chatListBody.id}`)
        this.$watch('searchInput', (value) => {
            if(value == ""){
                this.list = this.list.map((item) => {item.show = 1; return item;})
            }

            if(value != null){
                //search value and filter if search not exists change active to 0
                this.list = this.list.filter((item) => {
                    if(item.name.toLowerCase().includes(value.toLowerCase())){
                        item.show = 1;
                    }else{
                        item.show = 0;
                    }
                    return item;
                })
            }
        })

        this.loadChats()

        setInterval(() => {
            this.loadChats()
        }, 5000);
    },

    async loadChats(){
        const listm =await axios.get(route("chat.api.list"));

        const {status,data,message} = listm.data;

        if(status == true){
            this.list = data;
            this.list.map((item) => {
                item.show = 1;
                item.url = route("chat.box", item.id)
                return item;
            });

            Notiflix.Block.remove(`#${this.$refs.chatListBody.id}`)
        }

    },
}

const chatMessages = {
    chatId: window.chatId,
    chat: null,
    searching: false,
    search: "",

    form: {
        body: null,
        file: null
    },

    init(){
        this.loadMessages()

        setInterval(() => {
            if(this.searching == false){
                this.loadMessages()
            }
        }, 5000);
    },

    async sendMessage(){

        const frmData = new FormData();

        frmData.append("body", this.form.body);

        if(this.$refs.m_file.files.length > 0){
            frmData.append("file", this.$refs.m_file.files[0]);
        }


        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        frmData.append("_token", csrf);

        const result = axios.post(route("chat.send", this.chatId), frmData).then((response) => {
            Notiflix.Notify.success("Mesaj başarıyla gönderildi...")
            this.$refs.m_file.value = null;
            this.form.body = null;
            console.log(response)
        })
    },

    async loadMessages(){

        if(this.chatId == null){
            return;
        }

        const listm = await axios.get(route("chat.api.box", this.chatId), {
            params: {
                search: this.search
            }
        })

        const {status,data,message} = listm.data;

        if(status == true){
            this.chat = data;
            let scroll = document.querySelector(".scroll-mee");
            scroll.scrollTop = scroll.scrollHeight;
        }


    }
}

window.chats = chats;
window.chatMessages = chatMessages;
window.Alpine = Alpine;
window.chatBox = chatBox;
Alpine.start();
