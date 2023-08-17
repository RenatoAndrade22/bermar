<template>
    <div style="padding: 13px 20px;" id="form-sale">
        
        <vs-col vs-w="12" >
            <div class="form_item mb-3" style="width:100% !important;">
                <p class="text-label"><span class="required">*</span> Empresa</p>
                <!--
                    <vs-select
                        v-model="form.company"
                        autocomplete
                    >
                        <vs-select-item :key="index" :value="item" :text="item.name" v-for="item,index in companies" />
                    </vs-select>
                -->

                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Buscar por nome ou CNPJ"
                    v-model="form.company_name"
                    @input="searcEnterprise"
                />

                
                <div v-if="companies.length > 0 && list_products_search" class="list_companie_suggest">
                    <p 
                        v-for="(c, i) in companies" 
                        :key="i" 
                        @click="[form.company = c.id, list_products_search = false, form.company_name = c.name]"
                    >
                        {{ c.name }}
                    </p>
                </div>
            </div>
        </vs-col>


        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Metodo de pagamento</p>

                <vs-select
                    v-model="form.payment_method"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in payment_methods" />
                </vs-select>
            </div>
        </vs-col>

        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Tabela de preços</p>
                <vs-select
                    v-model="form.table_price"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in table_prices" />
                </vs-select>
            </div>
        </vs-col>



        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Condição de pagamento</p>
                <vs-select
                    v-model="form.payment_term"
                >
                    <vs-select-item :key="index" :value="item.code_integration" :text="item.name" v-for="item,index in payment_terms" />
                </vs-select>
            </div>
        </vs-col>
        
        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label">Previsão de Entrega</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Data da previsão de entrega "
                    v-model="form.delivery_date"
                    v-mask="'##/##/####'"
                />
            </div>
        </vs-col>



        <vs-col vs-w="4" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Tipo de frete</p>
                <vs-select
                    v-model="form.frete"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in frete" />
                </vs-select>
            </div>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span>Telefone transportadora</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Telefone"
                    v-model="form.phone"
                    v-mask="'(##) #####-####'"

                />
            </div>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Transportadora</p>
                <vs-select
                    v-model="form.carrier"
                >
                    <vs-select-item :key="index" :value="item.code_integration" :text="item.name" v-for="item,index in carriers" />
                </vs-select>
            </div>
        </vs-col>
        



        <vs-col vs-w="4" >
            <div class="form_item width_90">
                <p class="text-label">Tipo de frete redespacho</p>
                <vs-select
                    v-model="form.frete_redispatch"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in frete" />
                </vs-select>
            </div>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item width_90">
                <p class="text-label">Telefone transportadora redespacho</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Telefone"
                    v-model="form.phone_redispatch"
                    v-mask="'(##) #####-####'"

                />
            </div>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item width_90">
                <p class="text-label">Transportadora redespacho</p>
                <vs-select
                    v-model="form.carrier_redispatch"
                >
                    <vs-select-item :key="index" :value="item.code_integration" :text="item.name" v-for="item,index in carriers" />
                </vs-select>
            </div>
        </vs-col>
        

        <vs-col vs-w="12" >
            <div>
                <p class="text-label">Observação</p>
                <vs-textarea v-model="form.observation" style="height: 110px;" />
            </div>
        </vs-col>
        
        <vs-col vs-w="12" >
            <span class="error" v-if="filds">* Preencha todos os campos obrigatórios</span>

            <Button 
                v-model="active" 
                id_loadding="cadastro_venda" 
                name_button="Próxima etapa" 
                @send="nextStep"
                class="mt-3"
                style="text-align: right;"
            />

        </vs-col>

    </div>
</template>


<script>

import Button from '../../components/ButtonLoadding'
import {mask} from 'vue-the-mask'

export default {

    components: { Button },
    directives: {mask},

    name: "SaleComponent",

    props:{

        carriers:{
            type: Array,
            default(rawProps) {
                return []
            }
        },

        products:{
            type: Array,
            default(rawProps) {
                return []
            }
        },

        payment_methods:{
            type: Array,
            default(rawProps) {
                return []
            }
        },

        payment_terms:{
            type: Array,
            default(rawProps) {
                return []
            }
        },

        table_prices:{
            type: Array,
            default(rawProps) {
                return []
            }
        },
   
    },

    data(){
        return{
            
            active_record_payment: false,
            first_search: true,
            count_search: 0,
            list_products_search: false,
            
            active: false,
            error_company: false,
            error_payment: false,
            filds: false,
            companies: [],
            form:{
                company_name: null,
                company: null,
                phone: null,
                frete: null,
                payment_method: null,
                table_price: null,
                shipping: null,
                observation: null,
                delivery_date: null,
                payment_term: null,
                carrier: null,
                carrier_redispatch: null,
                phone_redispatch: null,
                frete_redispatch: null
            },

            frete: [
                {
                    id: 'C',
                    name: 'CIF'
                },
                {
                    id: 'F',
                    name: 'FOB'
                },
                {
                    id: 'R',
                    name: 'Redespacho'
                },
            ]
        }
    },

    methods:{

        searcEnterprise(){

            this.list_products_search = true

            if(this.form.company_name.length == 0){
                this.count_search = 0
                return true
            }

            if(!this.first_search && this.form.company_name.length <= 3){
                this.getEnterprise(this.form.company_name)
                return true
            }

            if(this.form.company_name.length < 3){
                this.count_search = 0
                return false
            }

            if(this.first_search){
                this.count_search = this.form.company_name.length 

                this.getEnterprise(this.form.company_name)
                this.first_search = false

                return true
            }

            if(this.form.company_name.length > 5 && (this.form.company_name.length > (this.count_search + 3) || this.form.company_name.length < (this.count_search - 3))){
                this.count_search = this.form.company_name.length 
                this.getEnterprise(this.form.company_name)
                return true
            }

        },

        getEnterprise(name_cnpj){
            //loading
            this.$vs.loading({
                container: '#form-sale',
                scale: 0.6
            })
            axios.get('/api/search-enterprise-name/'+name_cnpj).then((resp)=>{
                this.companies = resp.data
                this.$vs.loading.close("#form-sale > .con-vs-loading");
            })
        },

        nextStep(){
            if(this.validation()){
                this.filds = false
                this.$emit('send', this.form)
            }
        },

        validation(){

            if(
                    !this.form.company || !this.form.frete || !this.form.payment_method  || !this.form.table_price
                ||  !this.form.payment_term || !this.form.carrier
            ){
                this.filds = true
                return false
            }
            
            return true
        }
    }
}

</script>

<style>
.error{
    color:red;
}
.required{
    color:red;
}
.width_90{
    width: 90% !important;
}
.list_companie_suggest{
    background: #fff;
    position: relative;
    z-index: 999999 !important;
    height: 318px;
    overflow: auto;
}
.list_companie_suggest p{
    margin: 0;
    border: 1px solid #efeeee;
    padding: 14px;
    background: #fff;
    color: #000 !important;
    cursor: pointer;
}
.list_companie_suggest p:hover{
    background: #efeeee;
}
</style>