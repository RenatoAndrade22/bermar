<template>
    <div id="shopping" v-if="chat">

        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Garantia: Nome do Produto
                </vs-navbar-title>
            </div>
        </vs-navbar>

        <div style="width:100%; float:left;" class="mt-4">
            
            <div class="box">
                <div v-for="(message, i) in chat[0].messages" :class="'message '+message.type" :key="i">
                    <p v-if="message.message">{{ message.message }}</p>
                    <img v-if="message.file" :src="message.file" alt="" class="mb-2" style="width:100%;">
                    <span>{{ message.user.name }} - {{ message.created_at }}</span>
                </div>
            </div>

            <div v-if="url_image" style=" width:100%; float: left;background: #efeeee;padding: 10px;">
                <div :style="'background-image: url('+url_image+')'" class="image_preview"></div>
                <h6 class="mt-3" style="cursor: pointer;" @click="upload" >Enviar imagem</h6>
                <h6 style="cursor: pointer;" @click="url_image = null" >Cancelar</h6>
            </div>
            
            <vs-textarea
                class="text-area mt-3"
                label="Nova mensagem"
                v-model="message"
            />

            <input id="fileUpload" type="file" accept=".png, .jpg, .jpeg" v-on:change="onFileChange" hidden>
       
            <vs-button type="relief" size="small" class="float-left" @click="budget = !budget">Orçamento</vs-button>
          
            <vs-button v-if="validarRegrasUsuario(1)" type="relief" size="small" class="float-left" @click="assistance_active = !assistance_active">Assistencia Tecnica</vs-button>
            
            <div @click="chooseFiles" style="width: 30px;float: right;margin-left: 15px;">
                <UilPaperclip size="18px" />
            </div>

            <vs-button type="relief" size="small" class="float-end" @click="record">Enviar mensagem</vs-button>

            <vs-popup title="Orçamento" :active.sync="budget">

       
                    
                    <div v-if="!add_product">
                        <vs-button v-if="!validarRegrasUsuario(1)" @click="add_product = !add_product" type="relief" size="small" class="mb-2">Adicionar produto ao orçamento</vs-button>

                        <ul>
                            <li v-for="(p, i) in products_warranty">{{ p.name }} - R$: {{ p.price }} <span v-if="!validarRegrasUsuario(1)" @click="removeProduct(p.id)">x</span></li>
                        </ul>

                        <h6 class="text-center m-4">Total: {{ total_warranty }}</h6>

                        <vs-textarea
                            label="Descrição do orçamento"
                            v-model="description"
                        />

                        <vs-button v-if="!validarRegrasUsuario(1)" type="relief" size="small" @click="recordBudget">Cadastrar orçamento</vs-button>

                        </div>

                        <div v-if="add_product">

                        <p @click="add_product = !add_product"> Voltar </p>

                        <vs-input class="mb-2" placeholder="Buscar produto" v-model="search_product"/>

                        <div class="users_container">
                            <div class="enterprise" v-for="(product, i) in products_list">
                                <vs-radio v-model="product_selected" vs-name="radios1" :vs-value="product.id">
                                    <h6>{{ product.name }}</h6>
                                </vs-radio>
                            </div>
                        </div>

                        <vs-button type="relief" size="small" @click="addProductWarranty">Inserir produto</vs-button>
                    </div>


            </vs-popup>

            <vs-popup title="Assistencia Tecnica" :active.sync="assistance_active">
                <p>Adicione a assistencia tecnica ao chat.</p>

                <vs-input class="mb-2" placeholder="Buscar Assistencia Tecnica" v-model="search_assistance"/>

                <div class="users_container">
                    <div class="enterprise" v-for="(company, i) in assistance">
                        <vs-radio v-model="assistance_selected" vs-name="radios1" :vs-value="company.id">
                            <h6>{{ company.name }}</h6>
                            <p>{{ company.address }}</p>
                        </vs-radio>
                    </div>
                </div>
                
                <vs-button type="relief" size="small" @click="addAssistance">Adicionar ao chat</vs-button>
            </vs-popup>
        </div>
    
    </div>
</template>

<script>

import Pusher from 'pusher-js' // import Pusher
import { UilPaperclip } from '@iconscout/vue-unicons'
export default {
    name: "Chat",
    components:{ UilPaperclip },
    data(){
        return{
            assistance_selected: null,
            product_selected: null,
            colorx:'success',
            budget: false,
            assistance_active: false,
            add_product: false,
            chat: null,
            enterprise_id: null,
            message: null,
            user: null,
            buyer_id: null,
            users_assistance: null,
            search_assistance: null,
            url_image: null,
            file: null,
            products: [],
            search_product: null,
            products_warranty:[],
            total_warranty: 0,
            description: null,
            budget: null,
            budget_list:{
                budget_items:[],
                description: null,
            }, 
        }
    },
    methods:{

        validarRegrasUsuario(regra){
            return this.enterpriseType.includes(regra);
        },

        removeProduct(id){
            let products = this.$c(this.products_warranty).filter((item)=>{
                if(item.id == id){
                    this.total_warranty = parseFloat(this.total_warranty) - parseFloat(item.price)
                    this.total_warranty = this.total_warranty.toFixed(2)
                    return false;	
                }else{
                    return true;	
                }
            })

            this.products_warranty = products.items
        },

        recordBudget(){
            if(this.products_warranty.length > 0){
      
                axios.post('/api/budget/',{ 
                        description: this.description, 
                        products: this.products_warranty,
                        warranty_id: this.chat[0]['warranty_id']
                    }).then((data)=>{

                    this.budget = false
                    this.$vs.notify({
                        color:'success',
                        title:'Orçamento cadastrado!',
                        text:''
                    })

                })
                
            }else{
                this.$vs.notify({
                    color:'danger',
                    title:'Nenhum produto selecionado.',
                    text:''
                })
            }
        },

        upload(){

            let formData = new FormData();

            formData.append('file', this.file);
            axios.post('/api/upload-file-chat/'+this.chat[0].id, formData).then((data)=>{
                this.url_image = null
            })
        },

        onFileChange(e) {
            this.file = e.target.files[0];
            this.url_image = URL.createObjectURL(this.file);
        },

        chooseFiles(){
            document.getElementById("fileUpload").click()
        },

        addAssistance(){    
            if(this.assistance_selected){
                axios.put('/api/chat/'+this.chat[0].warranty.id, { enterprise_id: this.assistance_selected}).then((data)=>{
                    // cria a mensagem de Bot para o Chat, informando que a W tecnica foi inserida no chat.
                    axios.post('/api/chat-message', {user_id: 0, chat_id: this.chat[0].id, message: 'A Assistencia Tecnica foi inserida no chat.'}).then((data)=>{
                        this.assistance_active = false
                    })
                })
            }
        },

        record(){
            axios.post('/api/chat-message', {chat_id: this.chat[0].id, message: this.message}).then((data)=>{
                this.message = null
            })
        },

        getUsers(){
            axios.get('/api/companies-assistance').then((data)=>{
                this.users_assistance = data.data
            })
        },

        getBudget(){
            
            axios.get('/api/budget/'+this.chat[0]['warranty_id']).then((resp)=>{
               
                this.products_warranty = resp.data.budget_items
                this.description       = resp.data.description

                this.$c(resp.data.budget_items).each((item)=>{
                    this.total_warranty = parseFloat(this.total_warranty) + parseFloat(item.price)
                    this.total_warranty = this.total_warranty.toFixed(2)
                })                

            })
        },

        getMessages(){
            axios.get('/api/chat/'+this.$route.params.id).then((data)=>{
                
                this.buyer_id = data.data[0].user_id

                data.data[0].messages = this.$c(data.data[0].messages).map((message)=>{
                    return this.formatMessage(message)
                }).sortByDesc('id')

                this.chat = data.data

                this.getBudget()
            })
        },

        formatMessage(message){

            // as mensagens do comprador ficam a direita no chat
            if(this.buyer_id == message.user_id){
                message.type = 'right'
            }else{
                message.type = 'left'
            }

            // verifica se a mensagem é do BOT 
            if(message.user_id == 0){
                message.type = 'bot_message'
            }

            // verifica se a mensagem na esquerda é da bermar ou da assistencia tecnica.
            if(message.type == 'left'){
                if(message.user_id == 1){
                    message.type = message.type+' admin_color'
                }else{
                    message.type = message.type+' assistence_color'
                }
            }

            // limita o tamanho do nome na mensagem
            if(message.user.name.length > 15){
                message.user.name = message.user.name.substring(0,15)+'...';
            } 

            // converte o tipo de data para a data PT-BR
            let day = new Date(message.created_at)
            message.created_at = day.toLocaleString("pt-BR")

            return message
        },

        getProducts() {
            axios.get("/api/warranty-product").then((data) => {
                this.products = data.data
            });
        },

        addProductWarranty(){
            let product = this.$c(this.products).where('id', this.product_selected).first()

            this.products_warranty.push({id: product.id,name: product.name, price: product.price,})
            this.total_warranty = parseFloat(this.total_warranty) + parseFloat(product.price)
            this.total_warranty = this.total_warranty.toFixed(2)

            this.$vs.notify({
                color:'success',
                title:'Produto inserido!',
                text:''
            })
        }

    },
    computed:{

        enterpriseType(){
            return this.$store.state.enterpriseType;
        },

        userRules() {
            return this.$store.state.userRules;
        },

        assistance(){
            let assistance = this.users_assistance

            if(this.search_assistance){
                assistance = this.$c(assistance).filter((assist)=>{
                    return assist.name.toLowerCase().search(this.search_assistance.toLowerCase()) >= 0 || assist.address.toLowerCase().search(this.search_assistance.toLowerCase()) >= 0
                })
                assistance = assistance.items
            }

            return assistance
        },

        products_list(){
            let products = this.products

            if(this.search_product){
                products = this.$c(products).filter((assist)=>{
                    return assist.name.toLowerCase().search(this.search_product.toLowerCase()) >= 0
                })
                products = products.items
            }

            return products
        }
    },
    created() {
        this.user = JSON.parse(localStorage.user);
        this.enterprise_id = this.user.enterprise_id
        this.getMessages()
        this.getUsers()
        this.getProducts()
        

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('e9174196c305076ef1af', {
            cluster: 'sa1'
        });

        var channel = pusher.subscribe('my-channel');

        let vm = this
        channel.bind('my-event', function(data) { // merge da ultima messagem com a lista de mensages
            vm.chat[0].messages = [...[vm.formatMessage(data.message)], ...vm.chat[0].messages]
        });
    }
}
</script>

<style scoped>

    ul{
        padding: 0;
    }

    li{
        list-style: none;
        background: #efeeee;
        padding: 8px;
        margin-bottom: 2px;
    }
    
    li span{
        float: right;
        color: red;
        cursor: pointer;
    }

    .image_preview{
        width: 200px;
        height: 80px;
        float: left;
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
    }
    .icon_upload{
        cursor: pointer;
    }
    .header_page{
        padding: 20px 10px;
    }
    .header_page h3{
        font-size: 20px;
        font-weight: 600;
    }
 
    .box{
        height: 500px;
        overflow-y: auto;
        display: flex;
        flex-direction: column-reverse;
        padding: 16px 18px;
        border: 1px solid #efeeee;
        border-radius: 8px;
        width: 100%;
        float: left;
        box-shadow: 0 4px 20px 0 rgb(0 0 0 / 5%);
    }
    .message{
        width: 55%;
        margin-bottom: 15px;
        border-radius: 8px;
        padding: 10px 15px;
    }
    .message p {
        margin: 0;
        font-size: 14px !important;
    }
    .message span{
        font-size: 13px;
        float: right;
    }

    .left{
        float: left;
    }

    .admin_color{
        background: #e8f9f5;
    }

    .assistence_color{
        background: #b8e9dc;
    }

    .right{
        float: right;
        background: #efeeee;
        justify-content: stretch;
        margin-left: auto;
    }

    .bot_message{
        float: right;
        background: #3c6e71;
        width: 100%;
    }

    .bot_message p{
        color: #fff !important;
    }

    .bot_message span{
        color: #fff !important;
    }

    h5{
        text-align: center;
        float: left;
        width: 100%;
        padding: 20px 10px;
        font-size: 15px;
        margin-bottom: 16px;
    }
    .text-area{
        width: 100%;
        float: left;
    } 

    .users_container{
        width: 100%;
        height: 200px;
        margin-bottom: 15px;
        border: 1px solid #efeeee;
        overflow: auto;
    }
    .enterprise{
        padding: 15px;
        border-bottom: 1px solid #efeeee;
    }
    .enterprise h6, .enterprise p{
        margin: 0;
    }
    .enterprise label{
        display: inline-flex;
    }

    .enterprise h6{
        padding-left: 10px;
    }
    .enterprise p{
        padding-left: 10px;
    }
</style>
