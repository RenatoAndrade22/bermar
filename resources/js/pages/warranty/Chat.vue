<template>
    <div id="shopping" v-if="chat">

        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Garantia: {{ chat[0].warranty.sale_order.sale_order_items[0].product.name }}
                </vs-navbar-title>
            </div>
        </vs-navbar>

        <div style="width:100%; float:left;" class="mt-4">
            
            <div class="box">

                <div v-for="(message, i) in chat[0].messages" :class="message.type == 'right' ? 'message salesman' : 'message client'" :key="i">
                    <p>{{ message.message }}</p>
                    <span>{{ message.user.name }} - {{ message.created_at }}</span>
                </div>

            </div>
            <vs-textarea
                class="text-area mt-3"
                label="Nova mensagem"
                v-model="message"
            />
            <vs-button type="relief" size="small" class="float-left" @click="budget = !budget">Orçamento</vs-button>
            <vs-button type="relief" size="small" class="float-end" @click="record">Enviar mensagem</vs-button>

            <vs-popup title="Enviar Orçamento" :active.sync="budget">
                <h4>Enviar Orçamento</h4>
                <p>Envie o orçamento para a Bermar.</p>
                <vs-textarea
                    label="Descrição do orçamento"
                />
                <vs-button type="relief" size="small">Enviar</vs-button>
            </vs-popup>
        </div>
    
    </div>
</template>

<script>
export default {
    name: "Chat",
    data(){
        return{
            colorx:'success',
            budget: false,
            chat: null,
            enterprise_id: null,
            message: null,
            user: null
        }
    },
    methods:{

        record(){
            axios.post('/api/chat-message', {chat_id: this.chat[0].id, message: this.message}).then((data)=>{

                data.data.type = 'left'

                let name = this.user.name

                // limita o tamanho do nome na mensagem
                if(name.length > 15){
                    name = name.substring(0,15)+'...';
                } 
                data.data.user = {name: name}
                // converte o tipo de data para a data PT-BR
                let day = new Date(data.data.created_at)
                data.data.created_at = day.toLocaleString("pt-BR")

                this.chat[0].messages = [...[data.data], ...this.chat[0].messages]
console.log('aqqq', this.chat[0].messages )
                this.message = null
            })
        },

        getMessages(){
            axios.get('/api/chat/'+this.$route.params.id).then((data)=>{
                
                let buyer_id = data.data[0].user_id

                data.data[0].messages = this.$c(data.data[0].messages).map((message)=>{

                    // se o login é de empresa eu verifico quais mensagens tem o user_id do comprador e seto o type, para organizar a listagem de mensagens no chat
                    if(this.$user.enterprise.enterprise_type_id == 1){ 
                        if(buyer_id == message.user_id){
                            message.type = 'right'
                        }else{
                            message.type = 'left'
                        }
                    }else{ // se o login é do comprador, verifico quais mensagens tem o user_id do comprador para ficar para a esquerda.
                        if(buyer_id == message.user_id){
                            message.type = 'left'
                        }else{
                            message.type = 'right'
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
                }).sortByDesc('id')

                console.log('sss', data.data)
                this.chat = data.data
            })
        },

        
       
    },
    created() {
        this.user = JSON.parse(localStorage.user);
        this.enterprise_id = this.user.enterprise_id
        this.getMessages()
    }
}
</script>

<style scoped>
    .header_page{
        padding: 20px 10px;
    }
    .header_page h3{
        font-size: 20px;
        font-weight: 600;
    }
 
    .box{
        height: 390px;
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

    .salesman{
        float: left;
        background: #e8f9f5;
    }

    .client{
        float: right;
        background: #efeeee;
        justify-content: stretch;
        margin-left: auto;
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
</style>
