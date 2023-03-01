<template>
    <div>
        <vs-row class="list_products_grid">
            <vs-col vs-w="12">
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Buscar produto"
                    v-model="search"
                    danger-text="Esse campo é obrigatório"
                />
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
                    % de desconto
                </vs-col>
                
                <vs-col vs-w="2" class="p-2">
                    Total com desconto
                </vs-col>
            </vs-col>

            <vs-col vs-w="12" v-for="(product, index) in list_products" v-if="product.price" :key="index">
                <vs-col vs-w="4" class="p-2">
                    <p>{{ product.name }}</p>
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
                        <vs-button class="float-end mb-2" color="primary" @click="confirm = !confirm" type="filled">Cadastrar</vs-button>
                    </div>
                    <div v-if="confirm">
                        <vs-button class="float-end mb-2"  color="danger" @click="confirm = !confirm" type="filled">Cancelar</vs-button>
                        <vs-button @click="record" style="margin-right: 15px;" class="float-end mb-2"  color="success" type="filled">Confirmar venda</vs-button>
                    </div>
                </vs-col> 
            </vs-row>
        </div>
        
    </div>
</template>

<script>


export default {

    name: "GridProducts",
    props:{
        products:{
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
            states:[
                {
                    state: 'AC',
                    region: 'Norte'
                },
                {
                    state: 'AP',
                    region: 'Norte'
                },
                {
                    state: 'AM',
                    region: 'Norte'
                },
                {
                    state: 'PA',
                    region: 'Norte'
                },
                {
                    state: 'RO',
                    region: 'Norte'
                },
                {
                    state: 'RR',
                    region: 'Norte'
                },
                {
                    state: 'TO',
                    region: 'Norte'
                },


                {
                    state: 'AL',
                    region: 'Nordeste'
                },
                {
                    state: 'BA',
                    region: 'Nordeste'
                },
                {
                    state: 'CE',
                    region: 'Nordeste'
                },
                {
                    state: 'MA',
                    region: 'Nordeste'
                },
                {
                    state: 'PB',
                    region: 'Nordeste'
                },
                {
                    state: 'PE',
                    region: 'Nordeste'
                },
                {
                    state: 'PI',
                    region: 'Nordeste'
                },
                {
                    state: 'RN',
                    region: 'Nordeste'
                },
                {
                    state: 'SE',
                    region: 'Nordeste'
                },


                {
                    state: 'DF',
                    region: 'Centro-Oeste'
                },
                {
                    state: 'GO',
                    region: 'Centro-Oeste'
                },
                {
                    state: 'MT',
                    region: 'Centro-Oeste'
                },
                {
                    state: 'MS',
                    region: 'Centro-Oeste'
                },



                {
                    state: 'ES',
                    region: 'Sudeste'
                },
                {
                    state: 'MG',
                    region: 'Sudeste'
                },
                {
                    state: 'RJ',
                    region: 'Sudeste'
                },
                {
                    state: 'SP',
                    region: 'Sudeste'
                },

                {
                    state: 'PR',
                    region: 'Sul'
                },
                {
                    state: 'SC',
                    region: 'Sul'
                },
                {
                    state: 'RS',
                    region: 'Sul'
                },
            ],
        }
    },

    methods:{

        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        },

        noDiscount(product){
            this.list_products = this.$c(this.list_products).map((item) => {
                if(item.id == product.id){
                    product.total = (parseFloat(item.quantity) * parseFloat(item.price))
                }
                return product
            })

            this.withDiscount(product)
        },

        withDiscount(product){

            this.list_products = this.$c(this.list_products).map((item) => {
                if(item.id == product.id && product.total > 0){

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

                
                return product
            })

            this.total = this.$c(this.list_products).sum('total_discount')
        },

        record(){
            let products = this.$c(this.products).filter((item)=>{
                return item.total_discount > 0
            }).all()

            this.$emit('products_sale', products)
        }

    },

    computed:{

        list_products() {

            let products = this.$c(this.products)

            if(this.company){

                let region = this.$c(this.states).where('state', this.company.address[0]['state']).all()
                console.log('region',region[0].region)
                // tabela referente ao Estado da empresa
                let table_price = this.$c(this.table_prices).where('name', region[0].region) 
                
                table_price = table_price.items[0].prices

                products = this.$c(this.products).map((p)=>{
                    let price = this.$c(table_price).where('product_id', p.id)
                    if(price.items.length > 0){
                        p.price = price.items[0].price 
                    }else{
                        p.price = null
                    }

                    return p
                })
            }

            if (this.search) {
                products = this.$c(products).filter((product) => {
                    return product.name.toLowerCase().search(this.search) >= 0;
                });
            }

            return products.all()

        },
    }

}

</script>

<style scoped>

    .list_products_grid{
        height: 417px;
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