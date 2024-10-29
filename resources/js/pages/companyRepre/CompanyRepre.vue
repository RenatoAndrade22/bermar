<template>
    <div id="company-record">
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Empresas 
                </vs-navbar-title>
            </div>
            <!--
                <div style="margin-right: 50px;">
                    <vs-input class="search" placeholder="Buscar por nome ou CNPJ" v-model="search"/>
                    <vs-button type="relief" @click="searchEnterprise" icon="search" style="float:left;" />
                </div>
            -->
        </vs-navbar>
        <vs-table stripe :data="list_providers" class="header mt-5">
            <template slot="thead">
                <vs-th>
                    Razão Social
                </vs-th>
                <vs-th>
                    CNPJ
                </vs-th>
                <vs-th>
                    Telefone
                </vs-th>
                <vs-th>
                    Link
                </vs-th>
            </template>

            <template slot-scope="{data}">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data" >
                    <vs-td :data="data[indextr].name">
                        {{data[indextr].name}}
                    </vs-td>

                    <vs-td :data="data[indextr].cnpj">
                        {{data[indextr].cnpj}}
                    </vs-td>

                    <vs-td :data="data[indextr].phone">
                        {{data[indextr].phone}}
                    </vs-td>

                    <vs-td :data="data[indextr].id" style="width: 195px">
                        <div  class="icons" style="float:left; margin: 0 5px;">
                            <div @click="copyUrl(data[indextr].id)">
                                <vs-tooltip text="Copiar link para cadastro de vendedores.">
                                    <UilCopy size="19px" class="icon_view" />
                                </vs-tooltip>
                            </div>
                        </div>
                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>
    </div>
</template>

<script>

import { BRow, BCol, BTable, BButton, BFormInput, BFormGroup } from 'bootstrap-vue'
import { UilEye, UilEdit, UilTrashAlt, UilCopy } from '@iconscout/vue-unicons'
import Form from '../../components/Form'
import {mask} from "vue-the-mask";
import Multiselect from 'vue-multiselect'

export default {
    name: "Company",
    components:{
        BRow, BCol, BTable, BButton, BFormInput, BFormGroup, UilEye, UilEdit, UilTrashAlt, Form, Multiselect, UilCopy
    },
    directives: {mask},

    data(){
        return{
           
            search_cnpj: null,
            file_upload: true,
            search: null,
            delete_provider: null,
            providers:[],

            active_upload: false,
            active_form_address: false,
            form: {
                id: null,
                value_states: [],
                enterprise_type_ids: [],

                enterprise_type_id: null,
                enterprise_type_id_validate: false,

                enterprise_representative: null,
                enterprise_representative_validate: false,

                name: null,
                name_validate: false,

                email: null,
                email_validate: false,

                cnpj: null,
                cnpj_validate: false,

                phone: null,
                phone_validate: false,

                cell: null,

                status: true,
            },
            address:{

                id: null,

                zipcode: null,
                zipcode_validate: false,

                city_id: null,

                city: null,
                city_validate: false,

                state: null,
                state_validate: false,

                street: null,
                street_validate: false,
                
                number: null,
                number_validate: false,

                district: null,
                district_validate: false,

                complement: null,
                complement_validate: false,

                enterprise_id: null,

                status: true,
                region: 'Capital',
            },
            status:[
                {
                    id: 1,
                    name: 'Ativo'
                },
                {
                    id: 0,
                    name: 'Inativo'
                },
            ],
            region:[
                {
                    name: 'Capital'
                },
                {
                    name: 'Interior'
                },
                {
                    name: 'Litoral'
                },
            ],
            categories:[
                {
                    id: 2,
                    name: 'Revenda'
                },
                {
                    id: 3,
                    name: 'Representante'
                },
                {
                    id: 4,
                    name: 'Assistência'
                },
                {
                    id: 5,
                    name: 'Exportação'
                },
                
            ],
            representatives: [],
            errors_upload: []
        }
    },
    methods:{

        copyUrl(id){
            let url = window.location.origin+'/cadastro/vendedores/?'+btoa(id); 
            navigator.clipboard.writeText(url);
        },

        searchEnterprise(){
            axios.get('/api/enterprise-search/'+this.search).then((data)=>{
                this.providers = data.data
            })
        },

        getCompanies(){
            axios.get('/api/representante-empresas').then((data)=>{
                this.providers = data.data
            })
        }
    },

    created() {
        this.getCompanies()
    },

    computed:{
        list_providers(){
            let providers = this.providers
            return providers
        }
    }
}
</script>
<style>
    .form_item{
        width: 90%;
        height: 74px;
    }
</style>
<style scoped>
    .divisor{
        height: 1px;
        background: black;
        width: 94%;
    }
    .form_item{
        width: 90%;
        height: 74px;
    }
    .icons{
        float: left;
        flex-flow: row;
        display: flex;
        gap: 6px;
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
        width: 221px !important;
        margin-right: 12px;
        float: left;
    }
</style>
