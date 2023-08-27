<template>
    <div>
        <vs-row id="cadastro_venda">

            <Form
                :table_prices="table_prices"
                :payment_terms="payment_terms"
                :payment_methods="payment_methods"
                :carriers="carriers"
                v-if="step == 0"
                @send="nextStep"
             />

            <Grid
                :products="products"
                :company="form.company"
                :table_prices="this.prices"
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

        payment_methods:{
            type: Array,
            default(rawProps) {
                return []
            }
        },

        carriers:{
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

        payment_terms:{
            type: Array,
            default(rawProps) {
                return []
            }
        }

    },
    data(){
        return{
            error_company: false,
            error_payment: false,
            
            total: 0,

            prices: [],
            
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

            this.selectTabePrice()
        },

        selectTabePrice(){

            let ids = this.$c(this.form.tables).pluck('id').all()

            axios.post("/api/prices-by-table", ids).then((result) => { 
                this.prices = result.data
             })

        },

        record(e){
            this.$emit('products_sale', {products: e.products, form: this.form})
        }
    },
}

</script>

<style>
    #cadastro_venda{
        display: block !important;
    }
</style>