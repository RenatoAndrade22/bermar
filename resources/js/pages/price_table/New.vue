<template>
    <div class="new_table_price">

        <h1 v-if="!categ_edit">
            Selecione para qual Estado a tabela será cadastrada.
        </h1>
        <vs-row class="mb-4">
            <vs-col vs-w="12">
                <vs-select
                    class="selectExample"
                    label="Estado"
                    v-model="uf"
                >
                    <vs-select-item :key="index" :value="item.uf" :text="item.uf" v-for="item,index in ufs" />
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
            uf: null,
            ufs: [
                {
                    id: 1,
                    name: 'Acre',
                    uf: 'AC'
                },
                {
                    id: 2,
                    name: 'Alagoas',
                    uf: 'AL'
                },
                {
                    id: 3,
                    name: 'Amapá',
                    uf: 'AP'
                },
                {
                    id: 4,
                    name: 'Amazonas',
                    uf: 'AM'
                },
                {
                    id: 5,
                    name: 'Bahia',
                    uf: 'BA'
                },
                {
                    id: 6,
                    name: 'Ceará',
                    uf: 'CE'
                },
                {
                    id: 7,
                    name: 'Espírito Santo',
                    uf: 'ES'
                },
                {
                    id: 8,
                    name: 'Goiás',
                    uf: 'GO'
                },
                {
                    id: 9,
                    name: 'Maranhão',
                    uf: 'MA'
                },
                {
                    id: 10,
                    name: 'Mato Grosso',
                    uf: 'MT'
                },
                {
                    id: 11,
                    name: 'Mato Grosso do Sul',
                    uf: 'MS'
                },
                {
                    id: 12,
                    name: 'Minas Gerais',
                    uf: 'MG'
                },
                {
                    id: 13,
                    name: 'Pará',
                    uf: 'PA'
                },
                {
                    id: 14,
                    name: 'Paraíba',
                    uf: 'PB'
                },
                {
                    id: 15,
                    name: 'Paraná',
                    uf: 'PR'
                },
                {
                    id: 16,
                    name: 'Pernambuco',
                    uf: 'PE'
                },
                {
                    id: 17,
                    name: 'Piauí',
                    uf: 'PI'
                },
                {
                    id: 18,
                    name: 'Rio de Janeiro',
                    uf: 'RJ'
                },
                {
                    id: 19,
                    name: 'Rio Grande do Norte',
                    uf: 'RN'
                },
                {
                    id: 20,
                    name: 'Rio Grande do Sul',
                    uf: 'RS'
                },
                {
                    id: 21,
                    name: 'Rondônia',
                    uf: 'RO'
                },
                {
                    id: 22,
                    name: 'Roraima',
                    uf: 'RR'
                },
                {
                    id: 23,
                    name: 'Santa Catarina',
                    uf: 'SC'
                },
                {
                    id: 24,
                    name: 'São Paulo',
                    uf: 'SP'
                },
                {
                    id: 25,
                    name: 'Sergipe',
                    uf: 'SE'
                },
                {
                    id: 26,
                    name: 'Tocantins',
                    uf: 'TO'
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

                axios.post("/api/price_table",{name: this.uf, products: this.products}).then((data) => {
                    
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

            if(this.uf){
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