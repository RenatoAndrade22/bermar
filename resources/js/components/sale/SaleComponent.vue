<template>
    <div>
        <vs-row id="cadastro_venda">
           
            <Form
                :table_prices="table_prices"
                :payment_terms="payment_terms"
                :payment_methods="payment_methods"
                :carriers="carriers"
                :form_data="form"
                v-if="step == 0"
                @send="nextStep"
             />

            <Grid
                :products="products"
                :products_edit="form.products"
                :company="form.company"
                :table_prices="this.prices"
                v-if="step == 1" 
                @products_sale="record"
                @back_step="backStep"
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
        },

        sale_edit:{
            type: Object,
            default: {}
        }

    },
    data(){
        return{
            error_company: false,
            error_payment: false,
            
            total: 0,

            prices: [],
            
            form:{
                company_name: null,
                company: null,
                phone: null,
                frete: null,
                payment_method: null,
                table_price: null,
                tables: [],
                shipping: null,
                observation: null,
                delivery_date: null,
                payment_term: null,
                carrier: null,
                carrier_redispatch: null,
                products: [],
                phone_redispatch: null,
                frete_redispatch: null,
                value_nf: 0,
                volume: 0,
                
            },
        }
    },

    created() {

        if(this.sale_edit.tables != undefined){
            console.log('edit', this.sale_edit)
            this.form = this.sale_edit 
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
        },

        backStep(products){
            this.step = 0
        }
    },
}

</script>

<style>
    #cadastro_venda{
        display: block !important;
    }
</style>