<template>
    <div>
        <vs-row class="list_products_grid">
            <vs-col vs-w="12">
                <vue-simple-suggest
                    v-model="search"
                    :list="table_prices"
                    display-attribute="name_product"
                    value-attribute="product_id"
                    @select="selectName"
                    :filter-by-query="true">
                <!-- Filter by input text to only show the matching results -->
                </vue-simple-suggest>
            </vs-col>

            <!-- LISTAGEM DOS PRODUTOS -->
            <vs-col vs-w="12" class="mb-1" style="font-weight: 600;">
                <vs-col vs-w="4" class="p-2">
                    Produto
                </vs-col>

                <vs-col vs-w="2" class="p-2">
                    Quantidade
                </vs-col>

                <vs-col vs-w="2" class="p-2">
                    Total sem desconto
                </vs-col>

                <vs-col vs-w="2" class="p-2">
                    % Desconto
                </vs-col>
                
                <vs-col vs-w="2" class="p-2">
                    Total com desconto
                </vs-col>
            </vs-col>

            <vs-col vs-w="12" v-for="(product, index) in list_products" v-if="product.price" :key="index">
                <vs-col vs-w="4" class="p-2">
                    <p>{{ product.product_id }} - {{ product.name_product }}</p>
                </vs-col>
                <vs-col vs-w="2" class="p-2">
                    <vs-input
                        type="number"
                        v-model="product.quantity"
                        @input="noDiscount(product)"
                        min="0"
                    />
                </vs-col>
                <vs-col vs-w="2" class="p-2">
                    <vs-input
                        disabled
                        :value="formatCurrency(product.total)"
                    />
                </vs-col>
                
                <vs-col vs-w="2" class="p-2">
                    <vs-input
                        type="number"
                        v-model="product.discount"
                        @input="withDiscount(product)"
                        min="0"
                    />
                </vs-col>
                
                <vs-col vs-w="2" class="p-2">
                    <vs-input
                        disabled
                        :value="formatCurrency(product.total_discount)"
                    />
                </vs-col>
            </vs-col>
        </vs-row>

        <div class="bottom_grid_products">
            <vs-row>
                <vs-col vs-w="6">
                    <h3 class="total">
                        Total: {{ formatCurrency(total) }}
                    </h3>
                </vs-col>
                <vs-col vs-w="6">
                    <div v-if="!confirm">
                        <vs-button class="float-end mb-2" color="primary" @click="confirm = !confirm" type="filled">
                            Salvar
                        </vs-button>
                        <vs-button style="margin-right: 15px;" class="float-end mb-2"  color="danger" @click="backStep" type="filled">Voltar</vs-button>
                    </div>
                    <div v-if="confirm">
                        <vs-button class="float-end mb-2"  color="danger" @click="confirm = !confirm" type="filled">Cancelar</vs-button>
                        <vs-button @click="record" style="margin-right: 15px;" class="float-end mb-2"  color="success" type="filled">Confirmar venda</vs-button>
                        <vs-button style="margin-right: 15px;" class="float-end mb-2"  color="danger" @click="backStep" type="filled">Voltar</vs-button>
                    </div>
                </vs-col> 
            </vs-row>
        </div>
        
    </div>
</template>

<script>

import VueSimpleSuggest from 'vue-simple-suggest'
import 'vue-simple-suggest/dist/styles.css' // Optional CSS

export default {

    name: "GridProducts",

    components:{VueSimpleSuggest},

    props:{
        products:{
            type: Array,
            default(rawProps) {
                return []
            }
        },
        products_edit:{
            type: Array,
            default(rawProps) {
                return []
            }
        },
        companies:{
            type: Array,
            default(rawProps) {
                return []
            }
        },
        company:{
            type: Object,
            default(rawProps) {
                return {}
            }
        },
        table_prices:{
            type: Array,
            default(rawProps) {
                return []
            }
        }
    },

    data(){
        return{
            search: null,
            total: 0,
            confirm: false,
            table_price: null,
            table_price_id: null,
            list_products: [],
            edit: false,
        }
    },

    created() {
        if(this.products_edit.length > 0){
            this.list_products = this.products_edit
            this.edit = true
        }
    },

    methods:{

        selectName(product) {

            let p = this.$c(this.table_prices).where('product_id', product.product_id).first()
            
            p.quantity = 0
            p.total = 0
            p.discount = 0
            p.total_discount = 0

            this.list_products.unshift(p)

        },

        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        },

        noDiscount(product){

            this.list_products = this.$c(this.list_products).map((item) => {
                if(item.product_id == product.product_id){
                    product.total = (parseFloat(item.quantity) * parseFloat(item.price))
                }
                return item
            }).all()

            this.withDiscount(product)
        },

        updateTotal(p){
            this.list_products = this.$c(this.list_products).map((item) => {
                if(item.id == p.id){
                    item.discount = ((parseFloat(item.total) - parseFloat(item.total_discount)) / parseFloat(item.total)) * 100
                }
                return item
            }).all()
        },
        // const porcentagemDesconto = ((valorOriginal - valorComDesconto) / valorOriginal) * 100;

        withDiscount(product){

            this.list_products = this.$c(this.list_products).map((item) => {
                if(item.product_id == product.product_id && product.total > 0){

                    // retirando a porcentagem do valor total
                    let valor_total = product.total
                    let percentual = product.discount

                    let valor_percentual = (parseFloat(valor_total) * parseFloat(percentual)) / 100
                    let valor_final = valor_total - valor_percentual

                    product.total_discount = valor_final
                }

                if(product.total == 0){
                    product.discount = 0
                    product.total_discount = 0
                }

                
                return item
            }).all()

            this.total = this.$c(this.list_products).sum('total_discount')
        },

        record(){
            let products = this.$c(this.list_products).filter((item)=>{
                return item.quantity > 0
            }).all()

            this.$emit('products_sale', {products: products})
        },

        backStep(){
            this.$emit('back_step', this.list_products)
        }

    },

}

</script>

<style scoped>

    .list_products_grid{
        height: 417px;
        display: block !important;
    }
    .bottom_grid_products{
        width: 94%;
        position: absolute;
        bottom: 17px;
    }

    .products {
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