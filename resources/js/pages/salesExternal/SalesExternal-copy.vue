<template>
    <div id="page_sales">
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ sales.length }})</span> Vendas
                </vs-navbar-title>
            </div>
    
            <vs-button type="relief" @click="[popup_new = true, sale_edit_id = null]">
                Cadastrar nova venda externa
            </vs-button>
        </vs-navbar>
            
        <vs-table
            stripe
            :data="sales"
            class="header mt-5"
        >
            <template slot="thead">
                <vs-th>
                    Produto
                </vs-th>
                <vs-th>
                    Data
                </vs-th>
                <vs-th>
                    Valor
                </vs-th>
                <vs-th>
                    Série do produto
                </vs-th>
                <vs-th>
                    Numero NFE
                </vs-th>
                <vs-th>
                    NFE
                </vs-th>
            </template>
        </vs-table>
        <vs-popup title="Cadastrar nova venda" :active.sync="popup_new">
             
            <Form 
                v-if="popup_new"
            />
        </vs-popup>
    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes, UilBill, ButtonLoadding } from '@iconscout/vue-unicons'
import { UploadMedia, UpdateMedia } from 'vue-media-upload'
import axios from "axios"
import Form from '../../components/saleExternal/Form'
import ButtonComponent from '../../components/ButtonLoadding'
import {mask} from "vue-the-mask";
import VueHtml2pdf from 'vue-html2pdf'
import moment from 'moment';

export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes, UploadMedia, UpdateMedia, UilBill,
        Form, ButtonComponent, VueHtml2pdf
    },
    directives: {mask},
    data(){
        return{
            sales: [],
            popup_new: false, 
            sale_edit_id: null
        }
    },

    methods:{

        getExternalSales() {
            axios.get('/api/payment-terms').then((resp)=>{
                this.sales = resp.data
            })
        },
    },

    created() {
    },
   
    computed:{
        userRules() {
            return this.$store.state.userRules;
        },
        
    }
}
</script>
<style scoped>

    .boletos{
        width: 100%;
        float: left;
    }

    .actions{
        width: 100%;
        float: left;
    }

    .delete{
        cursor: pointer;
        color: red;
        float: right;
        margin-right: 16px;
    }

    .boleto{
        width: 200px;
        float: left;
        margin-right: 10px;
    }
    .sale_products{
        margin: 0;
        padding: 0;
    }
    .sale_products p{
        font-weight: 600 !important;
        margin: 0;
        color: #333 !important;
    }
    .sale_products span{
        color: rgb(238, 27, 33);
    }
    .sale_products li{
        list-style: none;
        border-bottom: 1px solid #efeeee;
        padding: 15px;
    }
    .error{
        color:red
    }
    .name{
        width: 90%;
        float: left;
    }
    .number_items{
        width: 10%;
        float: left;
    }
    .form_item{
        width: 100% !important;
    }
</style>
<style>
    #list-products{
        margin: 10px 0;
    }
    #list-products th{
        padding: 0px !important;
        padding-right: 10px !important;
    }
    #list-products td{
        padding: 0px !important;
        padding-right: 10px !important;
        border-bottom: 1px solid #777;
    }
    .pdf_sale{
        width: 100%;
        padding: 50px;
        z-index: 99999;
        margin: 0 auto;
        background: #fff;
    }
    .pdf_sale p{
        color: #000 !important;
        margin: 0;
        font-weight: 600 !important;
        font-size: 12px !important;
    }
    .pdf_sale p span{
        color: #000 !important;
        font-weight: 300;
    }
    .product_pdf{
        border: 1px solid #efeeee;
        padding: 20px;
    }
    .icons{
        float: left;
    }
    .icon_view{
        cursor: pointer;
    }
    .input-span-placeholder{
        margin-top: 4px;
        margin-left: 6px;
    }
    .vs-dialog-accept-button{
        background: #FF4757;
        padding: 7px 10px;
        color: #ffffff;
        border-radius: 8px;
        margin: 10px;
        cursor: pointer;
    }
    .vs-dialog-cancel-button{
        margin: 10px;
        cursor: pointer;
    }
    .vs-dialog-text{
        padding: 25px 20px;
    }
    .clear_select{
        cursor: pointer;
        margin: 21px 0px 0px 4px;
    }
</style>
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
</style>
