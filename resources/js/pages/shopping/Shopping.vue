<template>
    <div id="shopping">

        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ shopping.length }})</span> Compras
                </vs-navbar-title>
            </div>
        </vs-navbar>

        <div style="width:100%; float:left;" class="mt-4">
            <vs-tabs :color="colorx" alignment="fixed">

                <vs-tab @click="colorx = 'success'" label="Pedidos">
                    <div class="sale_info" v-for="(shop, index) in shopping" :key="index">
                        <div class="date">
                            <span>Data da compra: {{ formatDate(shop.created_at) }}</span>
                            <span class="float-end">N° do pedido: {{shop.id}}</span>
                        </div>
                        <h5 class="delivered" v-if="shop.delivered"><span class="status">{{ shop.status }}</span> | Seu produto chegou no dia {{ shop.delivery_day }}</h5>
                        <h5 class="pending" v-if="!shop.delivered"><span class="status">{{ shop.status }}</span> | Seu produto deve chegar no dia {{ shop.delivery_day }}</h5>
                        <div class="view_products">
                            <span @click="show = !show" v-if="!show">Ver produtos</span>
                            <span @click="show = !show" v-if="show">fechar produtos</span>
                        </div>
                        <template v-if="show">
                            <vs-row class="product" v-for="(product, i) in shop.sale_order_items" :key="i">
                                <vs-col vs-w="2">
                                    <div class="image">
                                        <img v-if="product.product.product_images[0]" :src="'/products-images/'+product.product.product_images[0].name">
                                    </div>
                                </vs-col>
                                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="4">
                                    <div class="info_delivery">
                                        <p class="name_product">{{ product.product.name }}</p>
                                        <p>Quantidade: {{ product.quantity }}</p>
                                        <p>Valor: {{ formatCurrency(product.product.price) }}</p>
                                    </div>
                                </vs-col>
                                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="4">
                                    <!--
                                    <div class="actions">
                                        <vs-button @click="downloadInvoice(product.product.id)" type="relief" size="small">Nota fiscal</vs-button>
                                        <vs-button type="relief" size="small">Manual</vs-button>
                                        <vs-button type="relief" size="small" @click="warranty = !warranty">Solicitar garantia</vs-button>
                                    </div>

                                    -->
                                    
                                </vs-col>
                        </vs-row>
                        </template>
                    </div>
                </vs-tab>
                <!--
                    <vs-tab @click="colorx = 'danger'" label="Pendentes">
                        <div class="con-tab-ejemplo">
                            Nenhuma compra encontrada
                        </div>
                    </vs-tab>
                    <vs-tab @click="colorx = 'warning'" label="Cancelados">
                        <div class="con-tab-ejemplo">
                            Nenhuma compra encontrada
                        </div>
                    </vs-tab>
                 -->   

            </vs-tabs>

        </div>
        <vs-popup title="Solicitar garantia" :active.sync="warranty">
            <h4>Deseja solicitar a garantia do produto?</h4>
            <p>
                Descreva no campo abaixo o motivo do pedido de garantia, caso necessário faça upload de imagens ou vídeos.
            </p>
            <vs-textarea
                label="Descrição"
                v-model="form_warranty.description"
            />
            <vs-button type="relief" size="small">Criar pedido de garantia</vs-button>
        </vs-popup>
    </div>
</template>

<script>
import axios from "axios";
import moment from 'moment';

export default {
    name: "Shopping",
    data(){
        return{
            warranty: false,
            form_warranty:{
                description: null,
            },
            colorx:'success',
            show: false,
            shopping:[
                {
                    status: "Enviado",
                    delivered: true,
                    delivery_day: "18/04/2022",
                    date: '15/04/2022',
                    items:[
                        {
                            image: 'https://bermar.ind.br/home/wp-content/uploads/2021/05/BM-73-CINZA-02.jpg',
                            name: "DESPOLPADOR DE TOMATE – BM 73 NR – BIVOLT",
                            quantity: '2',
                            value: '2.500,00',
                        },
                        {
                            image: 'https://bermar.ind.br/home/wp-content/uploads/2021/05/BM-73-CINZA-02.jpg',
                            name: "DESPOLPADOR DE TOMATE – BM 73 NR – BIVOLT",
                            quantity: '2',
                            value: '2.500,00',
                        },
                    ]
                },
            ]
        }
    },
    methods:{
        getSaleOrderByUser(){
            axios.get('/api/sale-orders-by-user').then((resp)=>{
                this.shopping = resp.data
            })
        },

        downloadInvoice(sale_order_id){
            axios.get('/api/download-invoice/'+sale_order_id).then((resp)=>{
                this.$vs.notify({color: "success", title: "Arquivo baixado!", text: ""})
                console.log('oii', resp.data)
                window.open('/invoices/'+resp.data.name, '_blank')
            })
        },

        formatDate(date){
            return moment(String(date)).format('MM/DD/YYYY hh:mm')
        },

        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        }
    },
    created() {
        this.getSaleOrderByUser()
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
    .search{
        margin-right: 20px;
    }
    .sale_info{
        border: 1px solid #efeeee;
        margin: 30px 10px;
        border-radius: 8px;
        width: 100%;
        float: left;
        box-shadow: 0 4px 20px 0 rgb(0 0 0 / 5%);
    }
    h5{
        text-align: center;
        float: left;
        width: 100%;
        padding: 20px 10px;
        font-size: 15px;
        margin-bottom: 16px;
    }
    .delivered{
        background: #efee;
    }
    .delivered .status{
        color: #76c893 !important;
    }
    .pending{
        background: #ffefef;
    }
    .pending .status{
        color: #c67575 !important;
    }
    .date{
        width: 100%;
        float: left;
        border-bottom: 1px solid #efeeee;
        font-size: 13px;
        padding: 10px 15px;
    }
    .image{
        width: 125px;
    }
    .image img{
        width: 100%;
        border-radius: 8px;
    }
    .product{
        padding: 15px;
    }
    .status{
        font-weight: bold !important;
        font-size: 15px !important;
        margin: 0;
    }
    .status_info{
        color: #000 !important;
    }
    .view_products{
        width: 100%;
        float: left;
        text-align: center;
        margin-bottom: 10px;
    }
    .view_products span{
        font-size: 13px;
        cursor: pointer;
    }
    .info_delivery p {
        margin: 0;
    }
    .name_product{
        font-weight: bold !important;
    }
</style>
