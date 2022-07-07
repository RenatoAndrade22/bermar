<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ list_providers.length }})</span> Usuários
                </vs-navbar-title>
            </div>
            <vs-input icon="search" class="search" placeholder="Buscar usuário" v-model="search"/>
            <vs-button type="relief" @click="popupActivo=true"
                >Cadastrar novos</vs-button
            >
        </vs-navbar>
        <vs-table stripe :data="list_providers" class="header mt-5">
            <template slot="thead">
                <vs-th>
                    Nome
                </vs-th>
                <vs-th>
                    CPF
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

                    <vs-td :data="data[indextr].cpf">
                        {{data[indextr].cpf}}
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
                        <div @click="editItem(data[indextr].id)" class="icons" style="float:left; margin: 0 5px;">
                            <vs-tooltip text="Editar">
                                <UilEdit size="19px" class="icon_view" />
                            </vs-tooltip>
                        </div>
                    </vs-td>
                    
                </vs-tr>
            </template>
        </vs-table>
        <vs-popup class="holamundo" title="Cadastrar Empresa" :active.sync="popupActivo">
            <vs-row vs-w="12" style="width: 100% !important; display: block;">

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Nome</p>
                        <vs-input
                            :danger="form.name_validate"
                            danger-text="Campo obrigatório"
                            placeholder="Nome"
                            v-model="form.name"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Empresa</p>
                        <vs-select
                            v-model="form.enterprise_id"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in companies" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Status</p>
                        <vs-select
                            v-model="form.status"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in status" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">CPF</p>
                        <vs-input
                            v-mask="'###.###.###.##'"
                            :danger="form.cpf_validate"
                            danger-text="Campo obrigatório"
                            placeholder="CPF"
                            v-model="form.cpf"
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

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Senha</p>
                        <vs-input
                            type="password"
                            :danger="form.password_validate"
                            :danger-text="form.password_confirm_text"
                            placeholder="Telefone"
                            v-model="form.password"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Confirme a Senha</p>
                        <vs-input
                            type="password"
                            :danger="form.password_confirm_validate"
                            danger-text="Campo obrigatório"
                            placeholder="Confirme a Senha"
                            v-model="form.password_confirm"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <div class="form_item">
                        <vs-button type="relief" @click="record" class="mt-4">
                            <span v-if="!edit_company">Cadastrar</span>
                            <span v-if="edit_company">Editar</span>
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

export default {
    name: "User",
    components:{
        BRow, BCol, BTable, BButton, BFormInput, BFormGroup, UilEye, UilEdit, UilTrashAlt, Form
    },
    directives: {mask},

    data(){
        return{
            search: null,
            delete_provider: null,
            edit_company: false,
            providers:[],
            popupActivo:false,
            companies: [],
            form: {
                id: null,

                enterprise_type_id: null,
                enterprise_type_id_validate: false,

                name: null,
                name_validate: false,

                email: null,
                email_validate: false,

                cpf: null,
                cpf_validate: false,

                phone: null,
                phone_validate: false,

                password: null,
                password_validate: false,
                password_confirm_text: 'Campo obrigatório',

                password_confirm: null,
                password_confirm_validate: false,

                status: true,

                enterprise_id: null
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

                axios.get('/api/get-city/'+this.address.zipcode.replace('-', '')).then((data)=>{
                    this.address.city_id = data.data.CityId
                    this.address.city    = data.data.CityDescription
                    this.address.state   = data.data.UnitFederation.Description
                    this.address.street  = data.data.Street
                    this.address.district   = data.data.District
                })

            }else{
                this.address.zipcode_validate = true
            }
        },

        record(){
            if(this.validate()){

                if(!this.edit_company){
                    axios.post('/api/user', this.form).then((data)=>{
                        this.address.enterprise_id = data.data.id
                        this.getUsers()
                        this.popupActivo = false
                        this.$toast.open({
                            message: 'Usuário cadastrado!',
                            type: 'success',
                        });
                    })
                }else{
                    axios.put('/api/user/'+this.form.id, this.form).then((data)=>{
                        this.getUsers()
                        this.popupActivo = false
                        this.$toast.open({
                            message: 'Usuário atualizado!',
                            type: 'success',
                        });
                    })
                }
                
            }
        },

        validate(){

            let i = true

            this.form.name_validate = !this.form.name ? true : false
            if(!this.form.name)                
                i = false

            this.form.email_validate = !this.form.email ? true : false
            if(!this.form.email)                
                i = false

            this.form.cpf_validate = !this.form.cpf ? true : false
            if(!this.form.cpf)                
                i = false

            this.form.phone_validate = !this.form.phone ? true : false
            if(!this.form.phone)                
                i = false

            if (!this.edit_company) {
                this.form.password_validate = !this.form.password ? true : false
                if(!this.form.password)                
                    i = false

                this.form.password_confirm_validate = !this.form.password_confirm ? true : false
                if(!this.form.password_confirm)                
                    i = false

                if(this.form.password && this.form.password_confirm){
                    if(this.form.password != this.form.password_confirm){
                        this.form.password_validate = true
                        this.form.password_confirm_text = 'Senha não compativel'
                        i = false
                    }
                }
            }else{
                if(this.form.password && this.form.password_confirm){
                    if(this.form.password != this.form.password_confirm){
                        this.form.password_validate = true
                        this.form.password_confirm_text = 'Senha não compativel'
                        i = false
                    }
                }
            }

            

            return i
        },

        getUsers(){
            axios.get('/api/user').then((data)=>{
                this.providers = data.data
            })
        },

        getCompanies(){
            axios.get('/api/user').then((data)=>{
                this.companies = data.data
            })
        },

        editItem(id){
            this.edit_company = true

            let company = this.$c(this.providers).where('id',id).first()

            console.log('company', company)

            this.form.id = company.id
            this.form.cpf = company.cpf
            this.form.email = company.email
            this.form.enterprise_id = company.enterprise_id
            this.form.name = company.name
            this.form.phone = company.phone
            this.form.status = company.status

            this.address = company.address

            this.popupActivo = true
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
        this.getUsers()
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
