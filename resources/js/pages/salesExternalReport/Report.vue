<template>
    <div id="page_comissions">

        <div class="header_table">
            <div>
                <p>Filtrar vendedor</p>
                <div>
                    <vs-input v-model="name_search" placeholder="Nome do vendedor" />
                </div>
            </div>
            <div>
                <p>Filtrar vendas</p>
                <div class="filter_inputs">
                    <date-picker v-model="dates" :lang="locale" format='DD/MM/YYYY'  range></date-picker>
                </div>
            </div>
            <vs-button @click="search" type="relief">
                Buscar
            </vs-button>
        </div>
            
        <vs-table
            stripe
            :data="sales"
            class="header mt-5"
        >
            <template slot="thead">
                <vs-th>
                    #
                </vs-th>
                <vs-th>
                    Vendedor
                </vs-th>
                <vs-th>
                    Empresa
                </vs-th>
                <vs-th>
                    Representante
                </vs-th>
                <vs-th>
                    Total comissão
                </vs-th>
            </template>
            <template slot-scope="{data}"> 
                <vs-tr :key="indextr" v-for="(tr, indextr) in data" class="table-line">
                    <vs-td :data="data[indextr]">
                        <div @click="openComissions(data[indextr])">
                            {{ (indextr + 1)}}
                        </div>
                    </vs-td>

                    <vs-td :data="data[indextr].sellet_name">
                        <div @click="openComissions(data[indextr])">
                            {{data[indextr].sellet_name}}
                        </div>
                    </vs-td>

                    <vs-td :data="data[indextr].enterprise_resale_name">
                        <div @click="openComissions(data[indextr])">
                            {{data[indextr].enterprise_resale_name}}
                        </div>
                    </vs-td>

                    <vs-td :data="data[indextr].enterprise_resale_name">
                        <div @click="openComissions(data[indextr])">
                            {{data[indextr].enterprise_repre_name}}
                        </div>
                    </vs-td>

                    <vs-td :data="data[indextr].total_comissions">
                        <div @click="openComissions(data[indextr])">
                            {{ valueFormat(data[indextr].total_comissions) }}
                        </div>
                    </vs-td>

                </vs-tr>
            </template>
        </vs-table>
        <vs-popup title="Comissões" :active.sync="popup_new" fullscreen>
             
            <Modal 
                v-if="popup_new"
                :seller="seller_selected"
            />
        </vs-popup>

    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes, UilBill, ButtonLoadding } from '@iconscout/vue-unicons'
import { UploadMedia, UpdateMedia } from 'vue-media-upload'
import axios from "axios"
import Modal from './Modal.vue'
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
        Modal, ButtonComponent, VueHtml2pdf, DatePicker 
    },
    directives: {mask},
    data(){
        return{
            sales: [],
            popup_new: false, 
            sale_edit_id: null,
            dates: null,
            name_search: null,
            seller_selected: null,
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

        openComissions(seller) {
            this.popup_new = true
            this.seller_selected = seller
        },

        search() {

            if (this.dates && this.dates[0] && this.dates[1]) {

                // Aqui você acessa as duas datas
                const [startDate, endDate] = this.dates;
                
                // Formata as datas no padrão internacional YYYY-MM-DD
                const formattedStartDate = new Date(startDate).toISOString().split('T')[0];
                const formattedEndDate = new Date(endDate).toISOString().split('T')[0];

                this.getExternalSales({start_date: formattedStartDate, end_date: formattedEndDate, name: this.name_search})
            } else {
                this.getExternalSales({name: this.name_search})
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
        },

        valueFormat(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
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

<style>
    #page_comissions .tr-values {
        cursor: pointer;
        background: #fff !important;
    }
    #page_comissions .tr-values:hover {
        background: #efeeee !important;
    }
    #page_comissions .header_table p{
        font-weight: bold !important;
        margin-bottom: 0 !important;
    }
</style>
