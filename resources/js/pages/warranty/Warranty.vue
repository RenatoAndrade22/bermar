<template>
    <div id="shopping">

        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Pedidos de garantia
                </vs-navbar-title>
            </div>
        </vs-navbar>

        <div style="width:100%; float:left;" class="mt-4">
            <vs-tabs :color="colorx" alignment="fixed">

                <vs-tab @click="colorx = 'success'" label="Em Processo">
                    <div class="card_warranty">
                        <vs-row>
                            <vs-col vs-w="6">
                                <p><b>Status:</b> Aguardando resposta</p>
                                <p><b>N° do pedido:</b> 528</p>
                                <p><b>Produto:</b> Aqui é o nome do produto.</p>
                                <p><b>Vendedor:</b> Nome da empresa vendedora</p>
                                <p><b>Data da solicitação:</b> 15/03/2022</p>
                            </vs-col>
                            <vs-col vs-w="6" vs-type="flex" vs-justify="center" vs-align="center">
                                <vs-button type="relief" size="small" @click="$router.push({ name: 'warranty_chat' })">Mensagens</vs-button>
                            </vs-col>
                        </vs-row>
                        
                    </div>
                </vs-tab>

                <vs-tab @click="colorx = 'danger'" label="Concluídos">
                    <div class="con-tab-ejemplo">
                        Nenhuma garantia encontrada.
                    </div>
                </vs-tab>
    
            </vs-tabs>
        </div>
    
    </div>
</template>

<script>
export default {
    name: "Warranty",
    data(){
        return{
            colorx:'success',
        }
    },
    methods:{
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
 
    .card_warranty{
        padding: 16px 18px;
        border: 1px solid #efeeee;
        margin: 30px 10px;
        border-radius: 8px;
        width: 100%;
        float: left;
        box-shadow: 0 4px 20px 0 rgb(0 0 0 / 5%);
    }
    .card_warranty p {
        margin: 0;
    }
    h5{
        text-align: center;
        float: left;
        width: 100%;
        padding: 20px 10px;
        font-size: 15px;
        margin-bottom: 16px;
    }
 
</style>
