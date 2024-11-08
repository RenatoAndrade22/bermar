<template>
    <div id="company-record">
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Empresas 
                </vs-navbar-title>
            </div>
   
            <div style="margin-right: 50px;">
                <vs-input class="search" placeholder="Buscar por nome ou CNPJ" v-model="search"/>
                <vs-button type="relief" @click="searchEnterprise" icon="search" style="float:left;" />
            </div>

            <vs-button type="relief" @click="[popupActivo=true, edit_company=false, resertAddress()]"
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
                    Telefone
                </vs-th>
                <vs-th>
                    Tipo
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

                    <vs-td :data="data[indextr].phone">
                        {{data[indextr].phone}}
                    </vs-td>

                    <vs-td :data="data[indextr].enterprise_type.name">
                        {{data[indextr].enterprise_type.name}}
                    </vs-td>

                    <vs-td :data="data[indextr].id" style="width: 195px">
                        <div  class="icons" style="float:left; margin: 0 5px;">

                            <div @click="editItem(data[indextr].id)">
                                <vs-tooltip text="Editar">
                                    <UilEdit size="19px" class="icon_view" />
                                </vs-tooltip>
                            </div>
                            
                            <div @click="copyUrl(data[indextr].id)" v-if="data[indextr].enterprise_type.name == 'Revenda'">
                                <vs-tooltip text="Copiar link para cadastro de vendedores.">
                                    <UilCopy size="19px" class="icon_view" />
                                </vs-tooltip>
                            </div>
                            
                        </div>
                    </vs-td>
                    
                </vs-tr>
            </template>
        </vs-table>
        <vs-popup class="holamundo" :title="edit_company ? 'Editar empresa' : 'Cadastrar empresa'" :active.sync="popupActivo">

            <vs-button v-if="!edit_company" style="margin-top: -15px;float: right;" @click="active_upload = !active_upload" type="line">
                <span v-if="!active_upload">Cadastrar por excel</span>
                <span v-if="active_upload">Voltar</span>
            </vs-button>

            <vs-row v-if="!active_upload" vs-w="12" style="width: 100% !important; display: block;" id="company_new">

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Categoria</p>
                        <!--
                            <vs-select
                                v-model="form.enterprise_type_id"
                                :danger="form.enterprise_type_id_validate"
                                danger-text="Campo obrigatório"
                            >
                                <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in categories" />
                            </vs-select>
                        -->
                        <div class="itens_check">
                            <div v-for="item, index in categories" :key="index" style="float:left; margin-right:20px;">
                              <input :value="item.id" v-model="form.enterprise_type_ids" class="form-check-input" type="checkbox" :id="'checkbox'+index">
                              <label class="form-check-label" :for="'checkbox'+index">
                                {{ item.name }}
                              </label>
                            </div>
                          </div>
                        
                    </div>
                </vs-col>
                
                <vs-col vs-type="flex" v-if="form.enterprise_type_ids.includes(2)" vs-justify="center" vs-align="center" vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Representante</p>
                        <vs-select
                            v-model="form.enterprise_representative"
                            :danger="form.enterprise_representative_validate"
                            danger-text="Campo obrigatório"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in representatives" />
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

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Celular</p>
                        <vs-input
                            v-mask="'(##) #####-####'"
                            placeholder="Celular"
                            v-model="form.cell"
                        />
                    </div>
                </vs-col>

                <vs-col  v-if="form.enterprise_type_ids.includes(3)" class="mt-2" vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.6/dist/vue-multiselect.min.css">
                    <div class="form_item">
                        <p class="text-label">Estados que representa</p>
                        <multiselect v-model="form.value_states" :options="options_states" :multiple="true"></multiselect>
                    </div>
                </vs-col>

                <vs-col  v-if="form.enterprise_type_ids.includes(3)" class="mt-2" vs-type="flex" vs-justify="center" vs-align="top" vs-w="12" style="height: 140px;">
                    <div class="form_item" >
                        <p class="text-label">Descrição</p>
                        <vs-textarea v-model="form.description" style="height: 110px;" />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <hr class="divisor" />
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" v-if="form.enterprise_type_id != 5">
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

                <template v-if="form.enterprise_type_id != 5">
                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                        <div class="form_item">
                            <vs-button type="relief" @click="searchCity" class="mt-4">
                                Buscar endereço
                            </vs-button>
                        </div>
                    </vs-col>
                </template>

                <template v-if="this.active_form_address || form.enterprise_type_id == 5 || edit_company">

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
                                :disabled="form.enterprise_type_id != 5"
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
                                :disabled="form.enterprise_type_id != 5"
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
                                <span v-if="!edit_company">Cadastrar</span>
                                <span v-if="edit_company">Editar</span>
                            </vs-button>
                        </div>
                    </vs-col>

                </template>
            </vs-row>
            <vs-row v-if="active_upload" vs-w="12" style="width: 100% !important; display: block;" id="company_new">
                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <input type="file" v-if="file_upload" @change="onFileChange" />
                </vs-col>
                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <div v-if="errors_upload.length > 0" style="width: 100%;float: left;text-align: center;padding: 10px;">
                        <p v-for="(e, i) in errors_upload" :key="i" style="background: mistyrose;color: red !important;padding: 5px;margin-bottom: 2px;">
                            {{ e.error }}
                        </p>
                    </div>
                </vs-col>
            </vs-row>
        </vs-popup>
    </div>
</template>

<script>
import readXlsxFile from 'read-excel-file'
import { BRow, BCol, BTable, BButton, BFormInput, BFormGroup } from 'bootstrap-vue'
import { UilEye, UilEdit, UilTrashAlt, UilCopy } from '@iconscout/vue-unicons'
import Form from '../../components/Form'
import {mask} from "vue-the-mask";
import {Money} from "v-money";
import Investment from "../Investment";
import Multiselect from 'vue-multiselect'

export default {
    name: "Company",
    components:{
        BRow, BCol, BTable, BButton, BFormInput, BFormGroup, UilEye, UilEdit, UilTrashAlt, Form, Multiselect, UilCopy
    },
    directives: {mask},

    data(){
        return{
            
            options_states: [
                "AC", // Acre
                "AL", // Alagoas
                "AP", // Amapá
                "AM", // Amazonas
                "BA", // Bahia
                "CE", // Ceará
                "DF", // Distrito Federal
                "ES", // Espírito Santo
                "GO", // Goiás
                "MA", // Maranhão
                "MT", // Mato Grosso
                "MS", // Mato Grosso do Sul
                "MG", // Minas Gerais
                "PA", // Pará
                "PB", // Paraíba
                "PR", // Paraná
                "PE", // Pernambuco
                "PI", // Piauí
                "RJ", // Rio de Janeiro
                "RN", // Rio Grande do Norte
                "RS", // Rio Grande do Sul
                "RO", // Rondônia
                "RR", // Roraima
                "SC", // Santa Catarina
                "SP", // São Paulo
                "SE", // Sergipe
                "TO", // Tocantins
            ],
            search_cnpj: null,
            file_upload: true,
            search: null,
            delete_provider: null,
            edit_company: false,
            providers:[],
            popupActivo:false,
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

            // Cria um elemento temporário de input
            const input = document.createElement('input');
            input.value = url;
            document.body.appendChild(input);

            // Seleciona o conteúdo do input e copia para a área de transferência
            input.select();
            input.setSelectionRange(0, 99999); // Para dispositivos móveis

            document.execCommand('copy');

            // Remove o elemento temporário
            document.body.removeChild(input);
        },

        searchEnterprise(){
            axios.get('/api/enterprise-search/'+this.search).then((data)=>{
                this.providers = data.data
            })
        },

        onFileChange(event) {
            this.file_upload = false
            //loading
            this.$vs.loading({
                container: '#company-record',
                scale: 0.6
            })

            const schema = {
                'Categoria': {
                    prop: 'categoria',
                    type: String,
                    required: true
                },
                'CNPJ': {
                    prop: 'cnpj',
                    type: String,
                    required: true
                },
                'Status': {
                    prop: 'status',
                    type: String,
                    required: true
                },
                'Razão Social': {
                    prop: 'razao_social',
                    type: String,
                    required: true
                },
           
                'E-mail': {
                    prop: 'email',
                    type: String,
                    required: true
                },
                'Telefone': {
                    prop: 'telefone',
                    type: String,
                    required: true
                },
                'CEP': {
                    prop: 'cep',
                    type: String,
                    required: true
                },
                'Rua': {
                    prop: 'rua',
                    type: String,
                    required: true
                },
                'Bairro': {
                    prop: 'bairro',
                    type: String,
                    required: true
                },
                'Complemento': {
                    prop: 'Complemento',
                    type: String
                },
                'Número': {
                    prop: 'numero',
                    type: String,
                    required: true,
                },
                'Cidade': {
                    prop: 'cidade',
                    type: String,
                    required: true
                },
                'Estado': {
                    prop: 'estado',
                    type: String,
                    required: true,
                    validate(value){
                        if(value.length != 2){
                            throw new Error('A coluna Estado deve ter 2 caracteres.') 
                        }
                    }
                },
                'Região': {
                    prop: 'regiao',
                    type: String,
                    required: true
                }
            }

            let xlsxfile = event.target.files ? event.target.files[0] : null;
            readXlsxFile(xlsxfile, {schema}).then((data) => {
                
                setTimeout(() => {
                    this.$vs.loading.close("#company-record > .con-vs-loading");
                }, 1)

                this.errors_upload = this.$c(data.errors).unique('column').map((e)=>{
                    if(e.error == "required"){
                        e.error = "O campo "+e.column+" é obrigatório."
                    }
                    return e
                }).all()
                
                this.file_upload = true

                if(this.errors_upload.length == 0){

                    for (var i = 0; i < data.rows.length; i++){
                        
                        let desc_categ = data.rows[i].categoria.toLowerCase()
                        desc_categ = desc_categ[0].toUpperCase() + desc_categ.substring(1)

                        let category = this.$c(this.categories).where('name', desc_categ).first()
                      
                        if(category){
                            axios.post('/api/enterprise', 
                            {
                                name: data.rows[i].razao_social,
                                enterprise_type_id: category.id,
                                email: data.rows[i].email,
                                cnpj: data.rows[i].cnpj,
                                phone: data.rows[i].telefone,
                                status: data.rows[i].status.toLowerCase() == 'ativo',
                                address:{
                                    number: data.rows[i].numero,
                                    street: data.rows[i].rua,
                                    district: data.rows[i].bairro,
                                    zipcode: data.rows[i].cep,
                                    city: data.rows[i].cidade,
                                    state: data.rows[i].estado,
                                    complement: data.rows[i].complemento === undefined ? null : data.rows[i].complemento,
                                    region: data.rows[i].regiao,
                                    
                                }
                            }).then((data)=>{

                            }).catch(error => {
                            });
                        }

                        if(i == (data.rows.length - 1)){
                            this.popupActivo = false
                            this.$toast.open({
                                message: 'Empresas cadastradas!',
                                type: 'success',
                            });
                        }
                        
                    }

                    setTimeout(() => {
                            this.$vs.loading.close("#company-record > .con-vs-loading");
                    }, 1)

                }
            })

        },
        
        resertAddress(){
            this.address.city_id = null
            this.address.city    = null
            this.address.state   = null
            this.address.street  = null
            this.address.district   = null
            this.address.name  = null
            this.address.email  = null
            this.address.cnpj  = null
            this.address.phone  = null
            this.address.status = true
        },

        searchCity(){
            if(this.address.zipcode){
                this.address.zipcode_validate = false

                this.active_form_address = true;
                axios.get('/api/get-city/'+this.address.zipcode.replace('-', '')).then((data)=>{
                    this.address.city_id = data.data.ibge
                    this.address.city    = data.data.localidade
                    this.address.state   = data.data.uf
                    this.address.street  = data.data.logradouro
                    this.address.district   = data.data.bairro
                    this.address.complement   = data.data.complemento
                })

            }else{
                this.address.zipcode_validate = true
            }
        },

        record(){

            this.$vs.loading({
                container: "#company_new",
                scale: 0.45,
            })

            if(this.validate()){

                if(!this.edit_company){

                    axios.post('/api/enterprise', this.form).then((data)=>{
                        this.address.enterprise_id = data.data.id
                        this.form.enterprise_type_ids = []
                        this.recordAddress()
                    })
                }else{
                    axios.put('/api/enterprise/'+this.form.id, this.form).then((data)=>{
                        this.recordAddress()
                    })
                }
                
            }else{
                //close loading
                setTimeout(() => {
                    this.$vs.loading.close("#company_new > .con-vs-loading");
                }, 1);  
            }
        },

        recordAddress(){ 

            if(!this.edit_company){
                axios.post('/api/address', this.address).then((data)=>{
                    this.popupActivo = false

                    this.getCompanies()

                    //close loading
                    setTimeout(() => {
                        this.$vs.loading.close("#company_new > .con-vs-loading");
                    }, 1);  

                    this.$toast.open({
                        message: 'Empresa cadastrada!',
                        type: 'success',
                    });
                })
            }else{

                axios.put('/api/address/'+this.address.id, this.address).then((data)=>{
                    this.popupActivo = false

                    this.getCompanies()

                    //close loading
                    setTimeout(() => {
                        this.$vs.loading.close("#company_new > .con-vs-loading");
                    }, 1);  

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
                   
            this.form.enterprise_type_id_validate = this.form.enterprise_type_ids.length ? true : false
            if(!this.form.enterprise_type_ids.length)                
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

            if(!this.form.enterprise_type_ids.includes(5)){
                this.address.zipcode_validate = !this.address.zipcode ? true : false
                if(!this.address.zipcode)                
                    i = false
            }

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

            if(this.form.enterprise_type_ids.includes(2)){
                this.form.enterprise_representative_validate = !this.form.enterprise_representative ? true : false
                if(!this.form.enterprise_representative)                
                    i = false
            }

            return i
        },

        getCompanies(){
            axios.get('/api/enterprise').then((data)=>{
                this.providers = data.data
                this.representatives = this.$c(data.data).filter((item)=>{
                    return item.enterprise_type_id == 3 || item.enterprise_type_id == 1
                }).all()
            })
        },

        editItem(id){

            this.edit_company = true

            let company = this.$c(this.providers).where('id',id).first()

            this.form.enterprise_representative = company.enterprise_id
            this.form.id = company.id
            this.form.cnpj = company.cnpj
            this.form.email = company.email
            this.form.enterprise_type_id = company.enterprise_type_id
            this.form.name = company.name
            this.form.phone = company.phone
            this.form.cell = company.cell
            this.form.status = company.status
            this.form.description = company.description
            this.form.value_states = company.representative_states.map((item)=>{
                return item.state
            })

            company.enterprise_rules.forEach(item => {
                this.form.enterprise_type_ids.push(item.enterprise_type_id) 
            })

            if (company.address.length > 0) {
                this.address.id = company.address[0].id
                this.address.zipcode = company.address[0].zipcode
                this.address.city = company.address[0].city
                this.address.city_id = company.address[0].city_id
                this.address.state = company.address[0].state
                this.address.street = company.address[0].street
                this.address.number = company.address[0].number
                this.address.district = company.address[0].district
                this.address.complement = company.address[0].complement
                this.address.enterprise_id = company.address[0].enterprise_id
                this.address.region = company.address[0].region
            }

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
