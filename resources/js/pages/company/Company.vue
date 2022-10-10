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
                        <p class="text-label">Categoria</p>
                        <vs-select
                            v-model="form.enterprise_type_id"
                            :danger="form.enterprise_type_id_validate"
                            danger-text="Campo obrigatório"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in categories" />
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
                            v-mask="'#####-###'"
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

                <template v-if="this.address.city_id">

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Rua</p>
                            <vs-input
                                :danger="address.street_validate"
                                danger-text="Campo obrigatório"
                                placeholder="Rua"
                                v-model="address.street"
                            />
                        </div>
                    </vs-col>

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Bairro</p>
                            <vs-input
                                :danger="address.district_validate"
                                danger-text="Campo obrigatório"
                                placeholder="Bairro"
                                v-model="address.district"
                            />
                        </div>
                    </vs-col>

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Complemento</p>
                            <vs-input
                                :danger="address.complement_validate"
                                danger-text="Campo obrigatório"
                                placeholder="Complemento"
                                v-model="address.complement"
                            />
                        </div>
                    </vs-col>

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Número</p>
                            <vs-input
                                :danger="address.number_validate"
                                danger-text="Campo obrigatório"
                                placeholder="Número"
                                v-model="address.number"
                            />
                        </div>
                    </vs-col>
                    

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Cidade</p>
                            <vs-input
                                disabled
                                :danger="address.city_validate"
                                danger-text="Campo obrigatório"
                                placeholder="Cidade"
                                v-model="address.city"
                            />
                        </div>
                    </vs-col>

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Estado</p>
                            <vs-input
                                disabled
                                :danger="address.state_validate"
                                danger-text="Campo obrigatório"
                                placeholder="Bairro"
                                v-model="address.state"
                            />
                        </div>
                    </vs-col>

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <p class="text-label">Região</p>
                            <vs-select
                                v-model="address.region"
                            >
                                <vs-select-item :key="index" :value="item.name" :text="item.name" v-for="item,index in region" />
                            </vs-select>
                        </div>
                    </vs-col>

                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                        <div class="form_item">
                            <vs-button type="relief" @click="record" class="mt-4">
                                Cadastrar
                            </vs-button>
                        </div>
                    </vs-col>

                </template>

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
            edit_company: false,
            providers:[],
            popupActivo:false,
            form: {
                id: null,

                enterprise_type_id: null,
                enterprise_type_id_validate: false,

                name: null,
                name_validate: false,

                email: null,
                email_validate: false,

                cnpj: null,
                cnpj_validate: false,

                phone: null,
                phone_validate: false,

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
                    axios.post('/api/enterprise', this.form).then((data)=>{
                        this.address.enterprise_id = data.data.id
                        this.recordAddress()
                    })
                }else{
                    axios.put('/api/enterprise/'+this.form.id, this.form).then((data)=>{
                        this.recordAddress()
                    })
                }
                
            }
        },

        recordAddress(){ 

            if(!this.edit_company){
                axios.post('/api/address', this.address).then((data)=>{
                    this.popupActivo = false

                    this.getCompanies()

                    this.$toast.open({
                        message: 'Empresa cadastrada!',
                        type: 'success',
                    });
                })
            }else{

                axios.put('/api/address/'+this.address.id, this.address).then((data)=>{
                    this.popupActivo = false

                    this.getCompanies()

                    this.$toast.open({
                        message: 'Empresa atualizada!',
                        type: 'success',
                    });
                })

            }
            
        },

        validate(){

            let i = true

            this.form.name_validate = !this.form.name ? true : false
            if(!this.form.name)                
                i = false
                   
            this.form.enterprise_type_id_validate = !this.form.enterprise_type_id ? true : false
            if(!this.form.enterprise_type_id)                
                i = false

            this.form.email_validate = !this.form.email ? true : false
            if(!this.form.email)                
                i = false

            this.form.cnpj_validate = !this.form.cnpj ? true : false
            if(!this.form.cnpj)                
                i = false

            this.form.phone_validate = !this.form.phone ? true : false
            if(!this.form.phone)                
                i = false

            this.address.zipcode_validate = !this.address.zipcode ? true : false
            if(!this.address.zipcode)                
                i = false

            this.address.city_validate = !this.address.city ? true : false
            if(!this.address.city)                
                i = false

            this.address.state_validate = !this.address.state ? true : false
            if(!this.address.state)                
                i = false

            this.address.street_validate = !this.address.street ? true : false
            if(!this.address.street)                
                i = false

            this.address.number_validate = !this.address.number ? true : false
            if(!this.address.number)                
                i = false

            return i
        },

        getCompanies(){
            axios.get('/api/enterprise').then((data)=>{
                this.providers = data.data
            })
        },

        editItem(id){
            this.edit_company = true

            let company = this.$c(this.providers).where('id',id).first()

            this.form.id = company.id
            this.form.cnpj = company.cnpj
            this.form.email = company.email
            this.form.enterprise_type_id = company.enterprise_type_id
            this.form.name = company.name
            this.form.phone = company.phone
            this.form.status = company.status

            this.address = company.address

            this.popupActivo = true
        },

        deleteItem(id){
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
            axios.delete('/api/providers/'+this.delete_providers.items[0].id).then((data)=>{
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
