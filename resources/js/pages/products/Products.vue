<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ list_products.length }})</span> Produtos
                </vs-navbar-title>
            </div>

            <vs-input icon="search" class="search" placeholder="Buscar produto" v-model="search"/>

            <vs-button type="relief" @click="$router.push({ name: 'products_new' })">Cadastrar novo</vs-button>

        </vs-navbar>

        <vs-table stripe :data="list_products" class="header mt-5">
            <template slot="thead">
                <vs-th>
                    Nome
                </vs-th>
                <vs-th>
                    Descrição
                </vs-th>
                <vs-th>
                    Preço
                </vs-th>
                <vs-th>
                    Status
                </vs-th>
                <vs-th>
                    Ações
                </vs-th>
            </template>

            <template slot-scope="{data}">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data" >
                    <vs-td :data="data[indextr].name">
                        {{data[indextr].name}}
                    </vs-td>

                    <vs-td :data="data[indextr].description">
                        {{data[indextr].description}}
                    </vs-td>

                    <vs-td :data="data[indextr].price">
                        {{data[indextr].price}}
                    </vs-td>

                    <vs-td :data="data[indextr].status">

                        <vs-button v-if="data[indextr].status == 1" line-origin="left" color="success" type="flat">Ativo</vs-button>
                        <vs-button v-if="data[indextr].status == 0" line-origin="left" color="danger" type="flat">Inativo</vs-button>

                    </vs-td>

                    <vs-td :data="data[indextr].id" style="width: 195px">

                        <div @click="viewItem(data[indextr].id)" class="icons">
                            <vs-tooltip text="Ver">
                                <UilEye size="19px" class="icon_view" @click="viewItem(data[indextr].id)" />
                            </vs-tooltip>
                        </div>

                        <div @click="editItem(data[indextr].id)" class="icons" style="float:left; margin: 0 5px;">
                            <vs-tooltip text="Editar">
                                <UilEdit size="19px" class="icon_view" />
                            </vs-tooltip>
                        </div>

                        <div @click="deleteItem(data[indextr].id)" class="icons">
                            <vs-tooltip text="Desativar">
                                <UilTrashAlt size="19px" class="icon_view" @click="deleteItem(data[indextr].id)" />
                            </vs-tooltip>
                        </div>

                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>
    </div>
</template>

<script>
import { BRow, BCol, BTable, BButton, BFormInput, BFormGroup } from 'bootstrap-vue'
import { UilEye, UilEdit, UilTrashAlt } from '@iconscout/vue-unicons'

import {TheMask} from "vue-the-mask";
import {Money} from "v-money";
import Investment from "../Investment";

export default {
    name: "Products",
    components:{
        BRow, BCol, BTable, BButton, BFormInput, BFormGroup, UilEye, UilEdit, UilTrashAlt
    },
    data(){
        return{
            search: null,
            delete_product: null,
            products:[]
        }
    },
    methods:{

        getProducts(){
            axios.get('http://bermar.pgv/api/products').then((data)=>{
                this.products = data.data
            })
        },

        viewItem(id){
            this.$router.push({ name: 'product_view', params: { id: id } })
        },

        editItem(id){
            this.$router.push({ name: 'product_edit', params: { id: id } })
        },

        deleteItem(id){
            console.log('name', id)

            this.delete_product = this.$c(this.products).where('id', id)
            this.$vs.dialog({
                type:'confirm',
                color: 'danger',
                title: `Confirme`,
                text: 'Deseja excluir o produto '+this.delete_product.items[0].name+'?',
                accept: this.acceptAlert,
                acceptText: 'Excluir',
                cancelText: 'Cancelar'
            })
        },

        acceptAlert(){

            axios.delete('http://bermar.pgv/api/products/'+this.delete_product.items[0].id).then((data)=>{

                this.products = this.$c(this.products).filter((item)=>{
                    return item.id !== this.delete_product.items[0].id
                })

                this.products = this.products.items

                this.$vs.notify({
                    color:'success',
                    title:'Produto excluído!',
                    text:''
                })
            })
        },

    },
    created() {
        this.getProducts()
    },
    computed:{

        list_products(){
            let products = this.products

            if (this.search){
                products = this.$c(products).filter((product)=>{
                    return product.name.toLowerCase().search(this.search) >= 0
                })
                products = products.items
            }

            return products
        }
    }
}
</script>

<style>
    .icons{
        float: left;
    }
    .icon_view{
        cursor: pointer;
    }
    .input-span-placeholder{
        margin-top: 4px;
        margin-left: 6px;
    }
    .vs-dialog-accept-button{
        background: #FF4757;
        padding: 7px 10px;
        color: #ffffff;
        border-radius: 8px;
        margin: 10px;
        cursor: pointer;
    }
    .vs-dialog-cancel-button{
        margin: 10px;
        cursor: pointer;
    }
    .vs-dialog-text{
        padding: 25px 20px;
    }
</style>
<style scoped>

    .header_page{
        padding: 20px 10px;
    }
    .header_page h3{
        font-size: 20px;
        font-weight: 600;
    }
    .search{
        margin-right: 20px;
    }
</style>
