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

    },
    data(){
        return{
            error_company: false,
            error_payment: false,
            
            step: 0,
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
            console.log('pai de todos', this.form)
        },
    },
}

</script>

<style scoped>

    .products {
        background: #efee;
        width: 100%;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
        border-bottom: 3px solid #fff;
        padding: 0px 15px;
        height: 230px;
        overflow: auto;
    }
    .products p{
        font-size: 14px !important;
        font-weight: 600 !important;
        margin: 0;
    }
    .products span{
        font-size: 12px;
    }
    .product-list{
        padding: 15px 0px;
        border-bottom: 3px solid #fff;
        min-height: 70px;
    }
</style>