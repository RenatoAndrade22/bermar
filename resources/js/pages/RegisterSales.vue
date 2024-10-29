<template>
    <div class="register">
        <div class="form">
            <vs-row>
                <vs-col vs-w="12" v-if="step == 0">
                    <h5 class="text-center">Dados pessoais</h5>
                    <hr> 
                    <vs-input
                        label="Nome"
                        placeholder="Informe seu nome"
                        class="mb-3"
                        v-model="form_user.name"
                        :danger="form_user.name_validate"
                        danger-text="Esse campo é obrigatório"
                    />
                    <vs-input
                        label="Email"
                        placeholder="Informe seu email"
                        class="mb-3"
                        v-model="form_user.email"
                        :danger="form_user.email_validate"
                        :danger-text="form_user.email_format_validate"
                    />
                    <vs-input
                        label="CPF"
                        placeholder="Informe seu cpf"
                        class="mb-3"
                        v-model="form_user.cpf"
                        :danger="form_user.cpf_validate"
                        danger-text="Esse campo é obrigatório"
                        v-mask="'###.###.###-##'"
                    />
                    <vs-input
                        label="Telefone"
                        placeholder="Informe seu telefone"
                        class="mb-3"
                        v-model="form_user.phone"
                        :danger="form_user.phone_validate"
                        danger-text="Esse campo é obrigatório"
                        v-mask="'(##) #####-####'"
                    />
                    <vs-input
                        label="Senha"
                        placeholder="Insira a senha"
                        class="mb-3"
                        type="password"
                        v-model="form_user.password"
                        :danger="form_user.password_validate"
                        :danger-text="form_user.password_confirm"
                    />
                    <vs-input
                        label="Confirmar Senha"
                        placeholder="Repita a senha"
                        class="mb-3"
                        type="password"
                        v-model="form_user.confirme_pass"
                        :danger="form_user.confirme_pass_validate"
                        :danger-text="form_user.password_confirm"
                    />
                    <vs-button :disabled="btn_disabled" type="relief" @click="recordUser">
                        <span>Cadastrar</span>
                    </vs-button>
                </vs-col>

                <vs-col vs-w="12" v-if="step == 2" class="end_record">
                    <h3>Seu cadastro terminou!</h3>
                    <span @click="$router.push({ name: 'login'})">Clique para fazer login.</span>
                </vs-col>

                <vs-col vs-w="12" v-if="errors" class="errors">
                    <vs-alert 
                        :active="true" 
                        color="danger" 
                        icon="new_releases" 
                        v-for="(error, i) in errors" 
                        :key="i"
                        class="mt-2"
                    >
                        <span>{{error[0]}}</span>
                    </vs-alert>
                </vs-col>
                
            </vs-row>
        </div>

    </div>
</template>

<script>
import {mask} from 'vue-the-mask'
import {BRow, BCol, BForm, BFormGroup, BFormInput, BFormSelect, BFormCheckboxGroup, BFormCheckbox, BButton, BCard,} from 'bootstrap-vue'

export default {
    components:{
        BRow, BCol, BForm, BFormGroup, BFormInput, BFormSelect, BFormCheckboxGroup, BFormCheckbox, BButton, BCard,
    },
    directives: {mask},
    data() {
        return {
            user: null,
            enterprise: null,
            errors: null,
            btn_disabled: false,
            active_address: false,
            form_user: {
                user_type_id: 1,
                name: null,
                name_validate: false,

                email: null,
                email_validate: false,
                email_format_validate: "Esse campo é obrigatório",
                
                cpf: null,
                cpf_validate: false,

                phone: null,
                phone_validate: false,

                password: null,
                password_validate: false,

                confirme_pass: null,
                confirme_pass_validate: false,
                password_confirm: "Esse campo é obrigatório",

            },

            show: true,
            erros: [],
            step: 0
        }
    },
    methods: {
        recordAddress(){
            if (this.validateAddress()) {
                axios.post('/api/register/address', this.form_address).then((item) =>{
                    this.step = 3;

                }).catch(e => {
                    let errors = e.response.data.errors;
                    this.errors = Object.values(errors);
                    this.btn_disabled = false
                });
            }
        },
        validateAddress(){
            let validate = true

            if(!this.form_address.city){
                this.form_address.city_validate = true
                validate = false
            }else{
                this.form_address.city_validate = false
            }

            if(!this.form_address.number){
                this.form_address.number_validate = true
                validate = false
            }else{
                this.form_address.number_validate = false
            }

            if(!this.form_address.street){
                this.form_address.street_validate = true
                validate = false
            }else{
                this.form_address.street_validate = false
            }

            if(!this.form_address.district){
                this.form_address.district_validate = true
                validate = false
            }else{
                this.form_address.district_validate = false
            }

            
            return validate
        },
        getCityForCEP(){
            axios.get('https://viacep.com.br/ws/'+this.form_address.zipcode.replace("-", "")+'/json/').then((item) =>{                
                this.form_address.city = item.data.localidade
                this.form_address.street = item.data.logradouro
                this.form_address.district = item.data.bairro
                this.form_address.state = item.data.uf
                
                if (item.data.localidade) {
                    this.active_address = true
                }
            })
        },
        recordEnterprise(){
            this.btn_disabled = true

            if (this.validateEnterprise()) {
                axios.post('/api/register/enterprise', this.form_enterprise).then((item) =>{

                this.form_address.enterprise_id = item.data.id
                this.enterprise = item.data
                this.step = 2;
                this.errors = null
                this.updateUser()
                this.btn_disabled = false
            }).catch(e => {
                let errors = e.response.data.errors;
                this.errors = Object.values(errors);
                this.btn_disabled = false
            });
            }else{
               this.btn_disabled = false
            }
        },

        validateEnterprise(){
            let validate = true

            if(!this.form_enterprise.cnpj){
                this.form_enterprise.cnpj_validate = true
                validate = false
            }else{
                this.form_enterprise.cnpj_validate = false
            }

            if(!this.form_enterprise.name){
                this.form_enterprise.name_validate = true
                validate = false
            }else{
                this.form_enterprise.name_validate = false
            }

            if(!this.form_enterprise.email){
                this.form_enterprise.email_validate = true
                validate = false
            }else{
                this.form_enterprise.email_validate = false
            }

            if(!this.form_enterprise.phone){
                this.form_enterprise.phone_validate = true
                validate = false
            }else{
                this.form_enterprise.phone_validate = false
            }

            return validate
        },

        recordUser(){
            this.btn_disabled = true

            if(this.validateUser()){
                this.record()
            }else{
                this.btn_disabled = false
            }
        },
        validateUser(){
            let validate = true
            if(!this.form_user.name){
                this.form_user.name_validate = true
                validate = false
            }else{
                this.form_user.name_validate = false
            }

            if(!this.form_user.email){
                this.form_user.email_validate = true
                validate = this.validateEmail()
            }else{
                validate = this.validateEmail()
            }

            if(!this.form_user.cpf){
                this.form_user.cpf_validate = true
                validate = false
            }else{
                this.form_user.cpf_validate = false
            }

            if(!this.form_user.phone){
                this.form_user.phone_validate = true
                validate = false
            }else{
                this.form_user.phone_validate = false
            }

            if(!this.form_user.password){
                this.form_user.password_validate = true
                validate = false
            }else{
                this.form_user.password_validate = false
                if(this.form_user.password != this.form_user.confirme_pass){
                    this.form_user.password_validate = true
                    validate = false
                    this.form_user.password_confirm = 'Insira a mesma senha.'
                }
            }

            if(!this.form_user.confirme_pass){
                this.form_user.confirme_pass_validate = true
                validate = false
            }else{
                this.form_user.confirme_pass_validate = false
                if(this.form_user.password != this.form_user.confirme_pass){
                    this.form_user.confirme_pass_validate = true
                    validate = false
                    this.form_user.password_confirm = 'Insira a mesma senha.'
                }
            }

            return validate
        },

        validadePass(){
            let validate
            if(this.form_user.password == this.form_user.confirme_pass){
                validate = true
                this.form_user.password_validate = false
                this.form_user.confirme_pass_validate = false
            }else{
                validate = false
                this.form_user.password_validate = true
                this.form_user.confirme_pass_validate = true
                this.form_user.password_confirm = 'Insira a mesma senha.'
            }
            return validate
        },

        validateEmail(){
            let validate
            let mailformat = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/"

            
            if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.form_user.email)){
                validate = true
                this.form_user.email_validate = false
            }else{
                validate = false
                this.form_user.email_validate = true
                this.form_user.email_format_validate = 'Email inválido'
            }

            return validate
        },

        record() {
            
            
            axios.post('/api/register/seller/'+this.$route.params.id, this.form_user).then((item) =>{
                this.user = item.data
                this.step = 2;
                this.errors = null
                this.btn_disabled = false
            }).catch(e => {
                let errors = e.response.data.errors;
                this.errors = Object.values(errors);
                this.btn_disabled = false
            });
            
        },

        updateUser(){
            axios.put('/api/update/user/'+this.user.id, {enterprise_id: this.enterprise.id}).then((item) =>{
            })
        }
    },
}
</script>
<style scoped>

.vs-con-input-label{
    width: 100% !important;
}
.form{
    margin: 0 auto;
    margin-top: 39px;
    width: 540px;
    padding: 30px;
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0px 4px 25px 0px rgb(0 0 0 / 10%);
}
.register{
    width: 100%;
    float: left;
    min-height: 100%;
    height: 100%;
    background: #ec1c24;
    padding-bottom: 50px;
}
h3{
    text-align: center;
    font-weight: 800;
    margin-top: 33px;
}
.end_record{
    text-align: center;
}
.end_record h3{
    margin: 0;
    color: #41ea41;
}
.end_record span{
    cursor: pointer;
}
</style>
