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
                    <div class="card_warranty" v-for="(w, i) in warranties" v-if="w.status == 1">
                        <vs-row>
                            <vs-col vs-w="6">
                                <p><b>Status:</b> {{ w.status }}</p>
                                <p><b>N° do pedido:</b> {{ w.sale_order_id }}</p>
                                <p><b>Produto:</b> {{ w.sale_order.sale_order_items[0].product.name }}</p>
                                <p><b>Vendedor:</b> {{ w.sale_order.enterprise.name }}</p>
                                <p><b>Data da solicitação:</b> {{ formatDate(w.sale_order.created_at) }}</p>
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
            warranties: []
        }
    },
    methods:{
        getWarranties(){
            axios.get('/api/warranty').then((data)=>{
                this.warranties = data.data
            })
        },
        formatDate(date){
            let day = new Date(date)
            return day.toLocaleDateString("pt-BR")
        }
    },
    created() {
        this.getWarranties()
    },
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
