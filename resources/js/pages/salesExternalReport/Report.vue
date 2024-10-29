<template>
    <div id="page_sales">

        <div class="header_table">
            <div class="search_filter">
                <p>Filtrar vendas</p>
                <div class="filter_inputs">
                    <date-picker v-model="dates" :lang="locale" format='DD/MM/YYYY'  range></date-picker>
                    <vs-button @click="searchDate" type="flat" size="small" style="margin-left: 10px;">
                        Buscar
                    </vs-button>
                </div>
            </div>
        </div>
            
        <vs-table
            stripe
            :data="sales"
            class="header mt-5"
        >
            <template slot="thead">
                <vs-th>
                    ID
                </vs-th>
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
                <vs-th>
                    Status
                </vs-th>
            </template>
            <template slot-scope="{data}">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data" >
                    <vs-td :data="data[indextr].id">
                        {{data[indextr].id}}
                    </vs-td>
                    <vs-td :data="data[indextr].product_name">
                        {{data[indextr].product_name}}
                    </vs-td>
                    <vs-td :data="data[indextr].date_sale">
                        {{formatDateToBR(data[indextr].date_sale)}}
                    </vs-td>
                    <vs-td :data="data[indextr].value">
                        {{data[indextr].value}}
                    </vs-td>
                    <vs-td :data="data[indextr].product_serial">
                        {{data[indextr].product_serial}}
                    </vs-td>
                    <vs-td :data="data[indextr].nfe_number">
                        {{data[indextr].nfe_number}}
                    </vs-td>
                    <vs-td :data="data[indextr].nfe_url">
                        <p style="float: left;"><a :href="data[indextr].nfe_url" target="_blank">Donwload</a></p>
                    </vs-td>
                    <vs-td :data="data[indextr].approved">
                        <p style="float: left;">
                            <span v-if="data[indextr].approved">Aprovada</span>
                            <span v-if="!data[indextr].approved">Pendente</span>
                        </p>
                    </vs-td>

                </vs-tr>
            </template>
        </vs-table>
        <vs-popup title="Cadastrar nova venda" :active.sync="popup_new">
             
            <Form 
                v-if="popup_new"
                @newSale="newSale"
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
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/pt-br';

export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes, UploadMedia, UpdateMedia, UilBill,
        Form, ButtonComponent, VueHtml2pdf, DatePicker 
    },
    directives: {mask},
    data(){
        return{
            sales: [],
            popup_new: false, 
            sale_edit_id: null,
            dates: null,
            locale: {
                monthBeforeYear: true,
                format: 'DD/MM/YYYY',
                separator: ' até ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'De',
                toLabel: 'Até',
                customRangeLabel: 'Personalizado',
                weekLabel: 'S',
                daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            }
        }
    },

    methods:{

        searchDate() {

            if (this.dates && this.dates[0] && this.dates[1]) {

                // Aqui você acessa as duas datas
                const [startDate, endDate] = this.dates;
                
                // Formata as datas no padrão internacional YYYY-MM-DD
                const formattedStartDate = new Date(startDate).toISOString().split('T')[0];
                const formattedEndDate = new Date(endDate).toISOString().split('T')[0];

                this.getExternalSales({start_date: formattedStartDate, end_date: formattedEndDate})
            } else {
                this.getExternalSales()
            }

        },
        newSale(item) {
            this.sales.unshift(item)
            this.popup_new = false
        },

        getExternalSales(params) {
            axios.get('/api/external-sales-report', {params}).then((resp)=>{
                this.sales = resp.data
            })
        },

        formatDateToBR(date) {
            const newDate = new Date(date);
            const day = newDate.getDate().toString().padStart(2, '0');
            const month = (newDate.getMonth() + 1).toString().padStart(2, '0');
            const year = newDate.getFullYear();
            return `${day}/${month}/${year}`;
        }
    },

    created() {
        this.getExternalSales()
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

    .header_table {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .search_filter {
        display: flex;
        flex-direction: column; /* Organiza os elementos em coluna */
    }
    .search_filter p {
        margin: 0;
        font-weight: bold !important;
    }
    
    .filter_inputs {
        display: flex;
        align-items: center; /* Alinha o date-picker e o botão "Buscar" lateralmente */
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
