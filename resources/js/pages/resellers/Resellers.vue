<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ list_providers.length }})</span> Revendedores
                </vs-navbar-title>
            </div>

            <vs-input icon="search" class="search" placeholder="Buscar revendedor" v-model="search"/>

        </vs-navbar>

        <vs-table stripe :data="list_providers" class="header mt-5">
            <template slot="thead">
                <vs-th>
                    Razão Social
                </vs-th>
                <vs-th>
                    CNPJ
                </vs-th>
                <vs-th>
                    Email
                </vs-th>
                <vs-th>
                    Telefone
                </vs-th>
                <vs-th>
                    Responsável
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

                    <vs-td :data="data[indextr].cnpj">
                        {{data[indextr].cnpj}}
                    </vs-td>

                    <vs-td :data="data[indextr].email">
                        {{data[indextr].email}}
                    </vs-td>

                    <vs-td :data="data[indextr].phone">
                        {{data[indextr].phone}}
                    </vs-td>

                    <vs-td :data="data[indextr].user.name">
                        {{data[indextr].user.name}}
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
    name: "Providers",
    components:{
        BRow, BCol, BTable, BButton, BFormInput, BFormGroup, UilEye, UilEdit, UilTrashAlt
    },
    data(){
        return{
            search: null,
            delete_provider: null,
            providers:[]
        }
    },
    methods:{

        getProviders(){
            axios.get('http://bermar.pgv/api/resellers').then((data)=>{
                this.providers = data.data
            })
        },

        viewItem(id){
            this.$router.push({ name: 'provider_view', params: { id: id } })
        },

        editItem(id){
            this.$router.push({ name: 'provider_edit', params: { id: id } })
        },

        deleteItem(id){
            console.log('name', id)

            this.delete_providers = this.$c(this.providers).where('id', id)
            this.$vs.dialog({
                type:'confirm',
                color: 'danger',
                title: `Confirme`,
                text: 'Deseja excluir o produto '+this.delete_providers.items[0].name+'?',
                accept: this.acceptAlert,
                acceptText: 'Excluir',
                cancelText: 'Cancelar'
            })
        },

        acceptAlert(){

            axios.delete('http://bermar.pgv/api/providers/'+this.delete_providers.items[0].id).then((data)=>{

                this.providers = this.$c(this.providers).filter((item)=>{
                    return item.id !== this.delete_providers.items[0].id
                })

                this.providers = this.providers.items

                this.$vs.notify({
                    color:'success',
                    title:'Produto excluído!',
                    text:''
                })
            })
        },

    },
    created() {
        this.getProviders()
    },
    computed:{

        list_providers(){
            let providers = this.providers

            if (this.search){
                providers = this.$c(providers).filter((providers)=>{
                    return providers.name.toLowerCase().search(this.search) >= 0
                })
                providers = providers.items
            }

            return providers
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
