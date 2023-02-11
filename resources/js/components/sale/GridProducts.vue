<template>
    <vs-row>
        <vs-col vs-w="12">
                    <vs-input
                        class="mb-3 mt-2"
                        placeholder="Buscar produto"
                        v-model="search"
                        danger-text="Esse campo é obrigatório"
                    />
                </vs-col>

                <div class="products">
                    <div v-for="(product, index) in list_products" class="product-list" v-if="product.price">
                        <div class="name">
                            <p>{{ product.name }}</p>
                            <span>Preço: {{ product.price }}</span>     
                        </div>
                        <div class="number_items">
                            <vs-input
                                min='0'
                                type="number"
                                v-model="product.quantity"
                            />
                        </div>
                    </div>
                </div>
            
                <vs-col vs-w="12">
                    <p class="total">
                        Total: {{ formatCurrency(total) }}
                    </p>
                </vs-col> 
    </vs-row>
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
        }
    },

    methods:{
        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        },
    },

    computed:{

        list_products() {

            let products = this.$c(this.products)

            if(this.company){

                //empresa selecionada
                let company = this.$c(this.companies).where('id', this.company)
                
                if(company){
                    // tabela referente ao Estado da empresa
                    let table_price = this.$c(this.table_prices).where('name', company.items[0]['address']['state'])       
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
               
            }

            if (this.form.search) {
                products = this.$c(products).filter((product) => {
                    return product.name.toLowerCase().search(this.form.search) >= 0;
                });
                products = products.items
            }

            return products

        },
    }

}

</script>