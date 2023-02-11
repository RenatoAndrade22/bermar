<template>
    <div style="padding: 13px 20px;">
        
        <vs-col vs-w="6" >
            <div class="form_item">
                <p class="text-label">Empresa</p>
                <vs-select
                    v-model="form.company"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in companies" />
                </vs-select>
            </div>
            <span class="error" v-if="error_company && !form.company">{{error_company}}</span>
        </vs-col>


        <vs-col vs-w="6" >
            <div class="form_item">
                <p class="text-label">Metodo de pagamento</p>
                <vs-select
                    v-model="form.payment_method"
                >
                    <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in payment_methods" />
                </vs-select>
            </div>
            <span class="error" v-if="error_payment && !form.company">{{error_payment}}</span>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item">
                <p class="text-label">Tipo de frete</p>
                <vs-select
                    v-model="form.frete"
                >
                    <vs-select-item :key="index" :value="item.name" :text="item.name" v-for="item,index in frete" />
                </vs-select>
            </div>
            <span class="error" v-if="error_payment && !form.company">{{error_payment}}</span>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item">
                <p class="text-label">Transportadora</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Transportadora"
                    v-model="form.shipping"
                    danger-text="Esse campo é obrigatório"
                />
            </div>
            <span class="error" v-if="error_company && !form.company">{{error_company}}</span>
        </vs-col>

        <vs-col vs-w="4" >
            <div class="form_item">
                <p class="text-label">Telefone</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Telefone"
                    v-model="form.phone"
                    danger-text="Esse campo é obrigatório"
                />
            </div>
            <span class="error" v-if="error_company && !form.company">{{error_company}}</span>
        </vs-col>

        <vs-col vs-w="12" >
            <div>
                <p class="text-label">Observação</p>
                <vs-textarea v-model="form.observation" style="height: 110px;" />
            </div>
            <span class="error" v-if="error_company && !form.company">{{error_company}}</span>
        </vs-col>
        
        <vs-col vs-w="12" >

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

export default {

    components: { Button },
    
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
            testando: 'Ola mundo',
            active: false,
            error_company: false,
            error_payment: false,
            form:{
                company: null,
                phone: null,
                frete: null,
                payment_method: null,
                shipping: null,
                phone: null,
                observation: null
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

    methods:{
        nextStep(){
            this.$emit('send', this.form)
        }
    }
}

</script>
