<template>
    <div style="padding: 13px 20px;">
        
        <vs-col vs-w="12" >
            <div class="form_item mb-3" style="width:100% !important;">
                <p class="text-label"><span class="required">*</span> Empresa</p>
                <vs-select
                    v-model="form.company"
                    autocomplete
                >
                    <vs-select-item :key="index" :value="item" :text="item.name" v-for="item,index in companies" />
                </vs-select>
            </div>
        </vs-col>


        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Metodo de pagamento <span @click="active_record_payment = true" style="color:red;float: right;">Cadastrar</span></p>

                <vs-select
                    v-model="form.payment_method"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in payment_methods" />
                </vs-select>
            </div>
        </vs-col>

        <vs-col vs-w="3" >
            <div class="form_item width_90">
                <p class="text-label"><span class="required">*</span> Tipo de frete</p>
                <vs-select
                    v-model="form.frete"
                >
                    <vs-select-item :key="index" :value="item.name" :text="item.name" v-for="item,index in frete" />
                </vs-select>
            </div>
        </vs-col>

        <vs-col vs-w="3" >
            <div class="form_item width_90">
                <p class="text-label">Transportadora</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Transportadora"
                    v-model="form.shipping"
                />
            </div>
        </vs-col>

        <vs-col vs-w="3" >
            <div class="form_item width_90">
                <p class="text-label">Telefone transportadora</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Telefone"
                    v-model="form.phone"
                    v-mask="'(##) #####-####'"

                />
            </div>
        </vs-col>

        <vs-col vs-w="3" >
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

        companies:{
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
            active: false,
            error_company: false,
            error_payment: false,
            filds: false,
            form:{
                company: null,
                phone: null,
                frete: null,
                payment_method: null,
                shipping: null,
                observation: null,
                delivery_date: null
            },

            frete: [
                {
                    id: 1,
                    name: 'CIF'
                },
                {
                    id: 2,
                    name: 'FOB'
                },
                {
                    id: 3,
                    name: 'Redespacho'
                },
            ]
        }
    },

    created(){
        this.companies = this.$c(this.companies).map((c)=>{
            c.name = c.name+' | '+c.cnpj
            return c
        }).all()
    },

    methods:{
        nextStep(){
            if(this.validation()){
                this.filds = false
                this.$emit('send', this.form)
            }
        },

        validation(){

            if(
                !this.form.company || !this.form.frete || !this.form.payment_method 
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
</style>