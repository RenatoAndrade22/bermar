<template>
    <div id="shopping">

        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Garantia: Aqui vai o nome do produto
                </vs-navbar-title>
            </div>
        </vs-navbar>

        <div style="width:100%; float:left;" class="mt-4">
            <div class="box">
                <div class="message salesman">
                    <p>Olá, essa é a mensagem do vendedor</p>
                    <span>15:35 - 20/04/2022</span>
                </div>
                
                <div class="message client">
                    <p>Essa é a mensagem do cliente</p>
                    <span>15:52 - 20/04/2022</span>
                </div>
                <div class="message client">
                    <p>Essa é a mensagem do cliente</p>
                    <span>15:52 - 20/04/2022</span>
                </div>
                <div class="message client">
                    <p>Essa é a mensagem do cliente</p>
                    <span>15:52 - 20/04/2022</span>
                </div>
                <div class="message client">
                    <p>Essa é a mensagem do cliente</p>
                    <span>15:52 - 20/04/2022</span>
                </div>
                <div class="message salesman">
                    <p>Olá, essa é a mensagem do vendedor</p>
                    <span>15:35 - 20/04/2022</span>
                </div>
                <div class="message salesman">
                    <p>Olá, essa é a mensagem do vendedor</p>
                    <span>15:35 - 20/04/2022</span>
                </div>
                <div class="message salesman">
                    <p>Olá, essa é a mensagem do vendedor</p>
                    <span>15:35 - 20/04/2022</span>
                </div>
                <div class="message salesman">
                    <p>Olá, essa é a mensagem do vendedor</p>
                    <span>15:35 - 20/04/2022</span>
                </div>
            </div>
            <vs-textarea
                class="text-area mt-3"
                label="Nova mensagem"
            />
            <vs-button type="relief" size="small" class="float-left" @click="budget = !budget">Orçamento</vs-button>
            <vs-button type="relief" size="small" class="float-end">Enviar mensagem</vs-button>

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
        }
    },
    methods:{
        getMessages(){
            this.$route.params.id
        }
    },
    created() {
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
