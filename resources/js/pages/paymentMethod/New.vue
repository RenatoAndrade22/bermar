<template>
    <div class="new_table_price">

        <h1 v-if="!categ_edit">
            Selecione para qual região a tabela será cadastrada.
        </h1>
        <vs-row class="mb-4">
            <vs-col vs-w="12">
                <vs-select
                    class="selectExample"
                    label="Região"
                    v-model="region"
                >
                    <vs-select-item :key="index" :value="item.name" :text="item.name" v-for="item,index in regions" />
                </vs-select>
            </vs-col>
        </vs-row>
            

        <vs-row class="row_product" vs-w="12" v-for="(product, i) in products" :key="i">
            <vs-col vs-type="flex" vs-justify="left" vs-align="center" vs-w="9" >
                <p class="product_name">{{ product.name }}</p> 
            </vs-col>
            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="3" >
                <div class="price">
                    <vs-input
                        v-if="money_active"
                        danger-text="Campo obrigatório"
                        placeholder="Preço"
                        v-model="product.price"
                        v-money="money"
                        masked
                    />
                </div>
                
            </vs-col>
        </vs-row>

        <vs-row>
            <vs-col vs-w="12" vs-type="flex" vs-justify="right" vs-align="center">
                <p v-if="error" class="error">Selecione um Estado.</p>

                <vs-button type="relief" @click="record" class="m-3" :disabled="button_inative">
                    <span v-if="!categ_edit">Cadastrar</span>
                    <span v-if="categ_edit">Editar</span>
                </vs-button>
            </vs-col>
        </vs-row>

    </div>
</template>


<script>
import {VMoney} from 'v-money'
import { UploadMedia, UpdateMedia } from 'vue-media-upload';
import { UilTimes } from '@iconscout/vue-unicons'
import { VueEditor } from "vue2-editor";

export default {
    name: "Record",
    components:{
        UploadMedia, UpdateMedia, UilTimes, VueEditor
    },
    data(){
        return{
            button_inative: false,
            categ_edit: false,
            money_active: false,
            products:[],
            region: null,
            regions: [
                {
                    id: 1,
                    name: 'Sul',
                },
                {
                    id: 2,
                    name: 'Sudeste',
                },
                {
                    id: 3,
                    name: 'Norte',
                },
                {
                    id: 4,
                    name: 'Nordeste',
                },
                {
                    id: 5,
                    name: 'Centro-Oeste',
                },
                {
                    id: 6,
                    name: 'Exportação',
                },
            ],

            error: false,
            money: {
                decimal: ',',
                thousands: '.',
                precision: 2,
                masked: false /* doesn't work with directive */
            }
        }
    },
    directives: {money: VMoney},

    methods:{
        getProductsBermar() {
            axios.get("/api/products-bermar").then((data) => {
                this.products = data.data
                this.money_active = true
            });
        },

        record(){
            this.button_inative = true
            if(this.validation()){

                axios.post("/api/price_table",{name: this.region, products: this.products}).then((data) => {
                    
                    this.$vs.notify({
                        color:'success',
                        title:'Tabela cadastrada!',
                        text:''
                    })

                    this.$router.push({ name: 'PriceTable' })

                    this.button_inative = false

                });
            }else{
                this.button_inative = false
            }
        },

        validation(){
            let i = false

            if(this.region){
                i = true
            }

            this.error = !i
            
            return i
        }

    },

    created(){
        this.getProductsBermar()
    }
}
</script>
<style scoped>
    .error{
        color: red !important;
    }
    .new_table_price .row_product{
        width: 100% !important; 
        display: block;
        border: 1px solid #efeeee;
        padding: 10px;
        min-height: 60px;
        margin-bottom: 10px;
    }
</style>