<template>
    <div>
        <vs-row id="cadastro_venda">

            <Form
                :companies="companies"
                :payment_methods="payment_methods"
                v-if="step == 0"
                @send="nextStep"
             />

            <Grid
                :companies="companies"
                :products="products"
                :company="form.company"
                :table_prices="table_prices"
                v-if="step == 1" 
                @products_sale="record"
             />
            
        </vs-row>
    </div>
</template>

<script>

import Form from '../../components/sale/Form'
import Grid from '../../components/sale/GridProducts'

export default {

    name: "SaleComponent",
    components:{
        Form, Grid
    },
    props:{

        step:{
            type: Number,
            default: 0
        },
        
        companies:{
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

        products:{
            type: Array,
            default(rawProps) {
                return []
            }
        },

    },
    data(){
        return{
            error_company: false,
            error_payment: false,
            
            total: 0,
            
            form:{
                company: null,
                payment_method: null,
                search: null,
                shipping: null,
                phone: null,
                observation: null
            },   
        }
    },

    methods:{

        nextStep(e){
            this.form = e
            this.step = 1
        },

        record(e){
            this.$emit('products_sale', {products: e.products, form: this.form, table_price_id: e.table_price_id})
        }
    },
}

</script>