<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                <span style="color: #ee1b21">({{ list_categories.length }})</span>
                Comissões
                </vs-navbar-title>
            </div>

            <vs-button type="relief" @click="registerNew"
                >Cadastrar nova</vs-button
            >
        </vs-navbar>
        <vs-table stripe :data="list_categories" noDataText="Nenhuma comissão encontrada." class="header mt-5">
            <template slot="thead">
                <vs-th> Nome </vs-th>
                <vs-th> Período vigência </vs-th>
                <vs-th> Ações </vs-th>
            </template>
            <template slot-scope="{ data }">

                <vs-tr :key="indextr" v-for="(tr, indextr) in data">

                    <vs-td :data="data[indextr].name">
                        {{ data[indextr].name }}
                    </vs-td> 

                    <vs-td :data="data[indextr]">
                        {{ data[indextr].start_date }} a  {{ data[indextr].end_date }}
                    </vs-td> 

                    <vs-td :data="data[indextr].id" style="width: 195px">
                        <div
                            @click="editItem(data[indextr])"
                            class="icons"
                            style="float: left; margin: 0 5px"
                        >
                            <vs-tooltip text="Editar">
                                <UilEdit size="19px" class="icon_view" />
                            </vs-tooltip>
                        </div>
    
                        <div @click="deleteItem(data[indextr].id)" class="icons">
                            <vs-tooltip text="Desativar">
                                <UilTrashAlt
                                size="19px"
                                class="icon_view"
                                @click="deleteItem(data[indextr].id)"
                                />
                            </vs-tooltip>
                        </div>
                    </vs-td>

                </vs-tr>
                
            </template>
        </vs-table>
        <vs-popup fullscreen :title="categ_edit ? 'Editar comissão' : 'Cadastrar comissão'" :active.sync="popup_new">
            <Modal :edit="categ_edit" @record="record" v-if="popup_new" />
        </vs-popup>
    </div>
</template>
<script>
import { UilEye, UilEdit, UilTrashAlt } from "@iconscout/vue-unicons";

import Modal from './Modal.vue'

export default {
    name: 'Categories',
    components:{
        UilEdit,
        UilTrashAlt,
        Modal
    },
    data(){
        return{
            popup_new: false,
            categ_edit : null,
            delete_categ: null,
            list_categories: [],
            categ_edit_id: null,
            form: {
                name: null,
                category_id:null,
                name_validation: false
            }
        }
    },
    methods:{

        registerNew(){
            this.popup_new = true
        },

        editItem(comission){
            this.popup_new = true
            this.categ_edit = comission
        },
        
        deleteItem(id){

            this.delete_item = this.$c(this.list_categories).where('id', id).first()
         
                this.$vs.dialog({
                    type: "confirm",
                    color: "danger",
                    title: `Confirme`,
                    text:
                    "Deseja excluir a comissão " + this.delete_item.name + "?",
                    accept: this.acceptDelete,
                    acceptText: "Excluir",
                    cancelText: "Cancelar",
                });
            
        },

        acceptDelete(){
            axios.delete("/api/comission/" + this.delete_item.id).then((data) => {
                this.list_categories = this.$c(this.list_categories).filter((item) => {
                    return item.id !== this.delete_item.id;
                });

                this.list_categories = this.list_categories.items;

                this.$vs.notify({
                    color: "success",
                    title: "Comissão excluída!",
                    text: "",
                });
            });
        },

        record(form){

                if (this.categ_edit) {

                    axios.put('/api/comission/'+this.categ_edit.id, form).then((resp)=>{
                        
                        this.categ_edit = null
                        this.popup_new = false
                        this.getCategories()

                        this.$vs.notify({
                            color:'success',
                            title:'Comissão atualizada!',
                            text:''
                        })
                    })

                }else{

                    axios.post('/api/comission', form).then((item)=>{
                        this.getCategories()
                        this.popup_new = false
                        this.categ_edit = null

                        this.$vs.notify({
                                color:'success',
                                title:'Comissão cadastrada!',
                                text:''
                            })
                        })
                    }
        },

        validation(){
            let i = true

            if (!this.form.name) {
                i = false
                this.form.name_validation = true
            }else{
                this.form.name_validation = false
            }

            return i
        },

        getCategories(){
            axios.get('/api/comission').then((item)=>{
                this.list_categories = item.data
            })
        },
        
    },
    created(){
        this.getCategories()
    },
    watch: {
        popup_new(value, old_value){
            if (!value) {
                this.form.name = null
                this.categ_edit = null
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.header_page {
  padding: 20px 10px;
}
.header_page h3 {
  font-size: 20px;
  font-weight: 600;
}

.text-label {
    margin-bottom: 3px;
    font-weight: 600 !important;
    color: #000 !important;
    font-size: 15px !important;
}
</style>