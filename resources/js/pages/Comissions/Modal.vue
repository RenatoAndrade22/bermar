<template>
    <div>

        <vs-row style="min-height: 90vh; display: block !important;">

            <vs-col vs-w="12">
                <vs-row style="padding: 0 25px; gap: 20px;">
                    <vs-col vs-w="3">
                        <p class="text-label">Descrição</p>
        
                        <vs-input
                            class="mb-3 mt-2"
                            placeholder="Descrição da comissão"
                            danger-text="Esse campo é obrigatório"
                            :danger="form.name_validation"
                            v-model="form.name"
                        />
                    </vs-col>
        
                    <vs-col vs-w="3">
                        <p class="text-label">Data Início</p>
        
                        <vs-input
                            class="mb-3 mt-2"
                            placeholder="Data início"
                            danger-text="Esse campo é obrigatório"
                            :danger="form.start_date_validation"
                            v-model="form.start_date"
                            v-mask="'##/##/####'"
                        />
                    </vs-col>
        
                    <vs-col vs-w="3">
                        <p class="text-label">Data final</p>
        
                        <vs-input
                            class="mb-3 mt-2"
                            placeholder="Data final"
                            danger-text="Esse campo é obrigatório"
                            :danger="form.end_date_validation"
                            v-model="form.end_date"
                            v-mask="'##/##/####'"
        
                        />
                    </vs-col>
                </vs-row>
            </vs-col>

            <vs-row class="p-4">

                <p class="text-label">Selecionar produtos</p>

                <vs-col vs-w="12" class="mb-4">
                    <vue-simple-suggest
                        v-model="search"
                        :list="products"
                        display-attribute="name"
                        value-attribute="id"
                        @select="selectName"
                        :filter-by-query="true">
                    <!-- Filter by input text to only show the matching results -->
                    </vue-simple-suggest>
                </vs-col>

                <p v-if="error_select_products" style="color:red !important;">É necessário selecionar produtos.</p>
    
                <!-- LISTAGEM DOS PRODUTOS -->
                <vs-col vs-w="12" class="mb-1" style="font-weight: 600;">
                    <vs-col vs-w="1" class="p-2">
                        #
                    </vs-col>
                    <vs-col vs-w="4" class="p-2">
                        Produto
                    </vs-col>
                    
                    <vs-col vs-w="2" class="p-2">
                        Comissão
                    </vs-col>
                    <vs-col vs-w="2" class="p-2">
                        Dobrado
                    </vs-col>
                    <vs-col vs-w="2" class="p-2">
                        Excluir
                    </vs-col>
                </vs-col>
    
                <vs-col vs-w="12" v-for="(product, index) in list_products" :key="index" style="border-bottom: 1px solid #efeeee;">

                    <vs-col vs-w="1" class="p-2">
                        <p>{{ index + 1 }}</p>
                    </vs-col>

                    <vs-col vs-w="4" class="p-2" style="margin-bottom: 0; margin-top: 8px;">
                        <p>{{ product.name }}</p>
                    </vs-col>
     
                    <vs-col vs-w="2" class="p-2">
                        <vs-input
                            v-if="money_active"
                            placeholder="Comissão"
                            v-model="product.comission"
                            v-money="money"
                            masked
                            @blur="updateComission(index, $event)"
                        />
                    </vs-col>
                    
                    <vs-col vs-w="2" class="p-2" >
                        <input type="checkbox" v-model="product.double" class="mt-2" />
                    </vs-col>

                    <vs-col vs-w="2" class="p-2 mt-2">
                        <div @click="deleteItem(product.product_id)" class="icons">
                            <vs-tooltip text="Excluir">
                                <UilTrashAlt
                                size="19px"
                                class="icon_view"
                                @click="deleteItem(product.product_id)"
                                />
                            </vs-tooltip>
                        </div>
                    </vs-col>

                </vs-col>
            </vs-row>    
            <vs-col vs-w="12">
                <vs-button type="relief" @click="record" class="mt-4" style="float: right;margin-right: 20px;">
                    <span v-if="!edit">Cadastrar</span>
                    <span v-if="edit">Atualizar</span>
                </vs-button>
            </vs-col>
        </vs-row>
    </div>
</template>

<script>
import { UilEdit, UilTrashAlt } from "@iconscout/vue-unicons";
import {VMoney} from 'v-money'
import {mask} from 'vue-the-mask'

export default {

    name: 'Modal',
    components:{UilEdit, UilTrashAlt},
    directives: {money: VMoney, mask},

    props: {
        edit: {
            type: Object,
            default: null
        }
    },

    data(){
        return{
            form:{
                name: null,
                name_validation: false,

                start_date: null,
                start_date_validation: false,

                end_date: null,
                end_date_validation: false,
                products: []
            },
            products: [],
            list_products: [],
            money_active: true,
            search: null,
            error_select_products: false,
            money: {
                decimal: ',',
                thousands: '.',
                precision: 2,
                masked: false /* doesn't work with directive */
            },
        }
    },

    created(){
        this.getProducts()
        if (this.edit) {
            this.form = this.edit
            this.list_products = this.edit.products
        }
    },

    methods: {
        record(){
            if(this.validation()){
                this.form.products = this.list_products 
                this.$emit('record', this.form)
            }
        },

        validation(){
            let v = true

            // validando o nome
            if (!this.form.name) {
                v = false
                this.form.name_validation = true
            } else {
                this.form.name_validation = false
            }

            // validando data inicial
            if (!this.form.start_date) {
                v = false
                this.form.start_date_validation = true
            } else {
                this.form.start_date_validation = false
            }

            // validando data final
            if (!this.form.end_date) {
                v = false
                this.form.end_date_validation = true
            } else {
                this.form.end_date_validation = false
            }

            if (this.list_products.length == 0) {
                v = false
                this.error_select_products = true
            }else{
                this.error_select_products = false
            }

            return v
        },

        updateComission(index, event){
            this.money_active = false
            this.list_products[index].comission = event.target.value
            this.money_active = true
        },

        deleteItem(id){
            this.list_products = this.$c(this.list_products).filter((item)=>{
                return item.product_id != id
            }).all()
        },

        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        },

        getProducts(){
            axios.get('/api/product').then((resp)=>{
                this.products = resp.data
            })
        },

        selectName(product) {
            this.search = null

            const alreadyExists = this.list_products.find(item => item.id === product.id)
            
            if (!alreadyExists) {
                let p = this.$c(this.products).where('id', product.id).first()
                
                let newProduct = {}

                newProduct.comission = 0
                newProduct.double = false
                newProduct.name = p.name
                newProduct.product_id = p.id

                this.list_products.unshift(newProduct)
            }
        }

    }
}

</script>