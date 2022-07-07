<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ list_providers.length }})</span> Empresas
                </vs-navbar-title>
            </div>
            <vs-input icon="search" class="search" placeholder="Buscar empresa" v-model="search"/>
            <vs-button type="relief" @click="popupActivo=true"
                >Cadastrar novo</vs-button
            >
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
                    Email
                </vs-th>
                <vs-th>
                    Telefone
                </vs-th>
                <vs-th>
                    Status
                </vs-th>
                <vs-th>
                    Ações
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

                    <vs-td :data="data[indextr].email">
                        {{data[indextr].email}}
                    </vs-td>

                    <vs-td :data="data[indextr].phone">
                        {{data[indextr].phone}}
                    </vs-td>

                    <vs-td :data="data[indextr].status">
                        {{data[indextr].status}}
                    </vs-td>

                    <vs-td :data="data[indextr].id" style="width: 195px">

                        <div @click="viewItem(data[indextr].id)" class="icons">
                            <vs-tooltip text="Ver">
                                <UilEye size="19px" class="icon_view" @click="viewItem(data[indextr].id)" />
                            </vs-tooltip>
                        </div>

                        <div @click="editItem(data[indextr].id)" class="icons" style="float:left; margin: 0 5px;">
                            <vs-tooltip text="Editar">
                                <UilEdit size="19px" class="icon_view" />
                            </vs-tooltip>
                        </div>

                        <div @click="deleteItem(data[indextr].id)" class="icons">
                            <vs-tooltip text="Desativar">
                                <UilTrashAlt size="19px" class="icon_view" @click="deleteItem(data[indextr].id)" />
                            </vs-tooltip>
                        </div>

                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>
        <vs-popup class="holamundo" title="Cadastrar Empresa" :active.sync="popupActivo">
            <vs-row vs-w="12" style="width: 100% !important; display: block;">

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Razão Social</p>
                        <vs-input
                            :danger="form.name_validate"
                            danger-text="Campo obrigatório"
                            placeholder="Razão Social"
                            v-model="form.name"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Categoria</p>
                        <vs-select
                            v-model="form.category"
                            :danger="form.category_validate"
                            danger-text="Campo obrigatório"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in categories" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">CNPJ</p>
                        <vs-input
                            v-mask="'##.###.###/####-##'"
                            :danger="form.cnpj_validate"
                            danger-text="Campo obrigatório"
                            placeholder="CNPJ"
                            v-model="form.cnpj"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Email</p>
                        <vs-input
                            :danger="form.email_validate"
                            danger-text="Campo obrigatório"
                            placeholder="Email"
                            v-model="form.email"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Telefone</p>
                        <vs-input
                            v-mask="'(##) #####-####'"
                            :danger="form.phone_validate"
                            danger-text="Campo obrigatório"
                            placeholder="Telefone"
                            v-model="form.phone"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <hr class="divisor" />
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">CEP</p>
                        <vs-input
                            :danger="address.zipcode_validate"
                            danger-text="Campo obrigatório"
                            placeholder="CEP"
                            v-model="address.zipcode"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <vs-button type="relief" @click="searchCity" class="mt-4">
                            Buscar endereço
                        </vs-button>
                    </div>
                </vs-col>

            </vs-row>
        </vs-popup>
    </div>
</template>

<script>
import { BRow, BCol, BTable, BButton, BFormInput, BFormGroup } from 'bootstrap-vue'
import { UilEye, UilEdit, UilTrashAlt } from '@iconscout/vue-unicons'
import Form from '../../components/Form'
import {mask} from "vue-the-mask";
import {Money} from "v-money";
import Investment from "../Investment";

export default {
    name: "Company",
    components:{
        BRow, BCol, BTable, BButton, BFormInput, BFormGroup, UilEye, UilEdit, UilTrashAlt, Form
    },
    directives: {mask},

    data(){
        return{
            search: null,
            delete_provider: null,
            providers:[],
            popupActivo:false,
            form: {
                category: null,
                category_validate: false,

                name: null,
                name_validate: false,

                email: null,
                email_validate: false,

                cnpj: null,
                cnpj_validate: false,

                phone: null,
                phone_validate: false,
            },
            address:{
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
            },
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
                }
            ]
        }
    },
    methods:{

        searchCity(){
            if(this.address.zipcode){
                this.address.zipcode_validate = false
            }else{
                this.address.zipcode_validate = true
            }
        },

        record(){
            if(this.validate){
                
            }
        },

        validate(){
            let i = true

            this.form.name_validate = !this.form.name ? true : false
            if(!this.form.name)                
                i = false
                
            
            return i
        },

        getCompanies(){
            axios.get('/api/enterprise').then((data)=>{
                this.providers = data.data
            })
        },

        viewItem(id){
            this.$router.push({ name: 'provider_view', params: { id: id } })
        },

        editItem(id){
            this.$router.push({ name: 'provider_edit', params: { id: id } })
        },

        deleteItem(id){
            console.log('name', id)

            this.delete_providers = this.$c(this.providers).where('id', id)
            this.$vs.dialog({
                type:'confirm',
                color: 'danger',
                title: `Confirme`,
                text: 'Deseja excluir o produto '+this.delete_providers.items[0].name+'?',
                accept: this.acceptAlert,
                acceptText: 'Excluir',
                cancelText: 'Cancelar'
            })
        },

        acceptAlert(){
            axios.delete('http://bermar.pgv/api/providers/'+this.delete_providers.items[0].id).then((data)=>{
                this.providers = this.$c(this.providers).filter((item)=>{
                    return item.id !== this.delete_providers.items[0].id
                })

                this.providers = this.providers.items

                this.$vs.notify({
                    color:'success',
                    title:'Produto excluído!',
                    text:''
                })
            })
        },

    },
    created() {
        this.getCompanies()
    },
    computed:{

        list_providers(){
            let providers = this.providers

            if (this.search){
                providers = this.$c(providers).filter((providers)=>{
                    return providers.name.toLowerCase().search(this.search) >= 0
                })
                providers = providers.items
            }

            return providers
        }
    }
}
</script>

<style>
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
        margin-right: 20px;
    }
</style>
