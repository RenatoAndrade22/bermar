<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                <span style="color: #ee1b21">({{ list_categories.length }})</span>
                Família
                </vs-navbar-title>
            </div>

            <vs-button type="relief" @click="registerNew"
                >Cadastrar nova</vs-button
            >
        </vs-navbar>
        <vs-table stripe :data="list_categories" noDataText="Nenhuma família encontrada." class="header mt-5">
            <template slot="thead">
                <vs-th> Nome </vs-th>
                <vs-th> Família pai </vs-th>
                <vs-th> Produtos </vs-th>
                <vs-th> Ações </vs-th>
            </template>
            <template slot-scope="{ data }">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="data[indextr].name">
                        {{ data[indextr].name }}
                    </vs-td>

                    <vs-td :data="data[indextr].category_name">
                        <div v-if="data[indextr].category_name">
                            {{ data[indextr].category_name }}
                        </div>
                        
                    </vs-td>
                   
                    <vs-td :data="data[indextr].products">
                        {{ data[indextr].products.length }}
                    </vs-td>
                    <vs-td :data="data[indextr].id" style="width: 195px">
                        <div
                            @click="editItem(data[indextr].id)"
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
        <vs-popup :title="categ_edit ? 'Editar família' : 'Cadastrar família'" :active.sync="popup_new">
            <h4>
                <span v-if="categ_edit">Editar família</span>    
                <span v-if="!categ_edit">Cadastrar família</span>
            </h4>
            
             <vs-row>
                    <vs-col vs-w="12">
                        <p class="text-label">Nome</p>

                        <vs-input
                            class="mb-3 mt-2"
                            placeholder="Nome da família"
                            v-model="form.name"
                            :danger="form.name_validation"
                            danger-text="Esse campo é obrigatório"
                        />
                    </vs-col>

                    <p class="text-label">Família pai</p>
                    <vs-select
                        v-model="form.category_id"
                        autocomplete
                    >
                        <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in list_categories" v-if="item.id != categ_edit_id" />
                    </vs-select>


                    <vs-col vs-w="12">
                        <vs-button type="relief" @click="record" class="mt-4">
                            <span v-if="!categ_edit">Cadastrar</span>
                            <span v-if="categ_edit">Editar</span>
                        </vs-button>
                    </vs-col>

             </vs-row>
        </vs-popup>
    </div>
</template>
<script>
import { UilEye, UilEdit, UilTrashAlt } from "@iconscout/vue-unicons";

export default {
    name: 'Categories',
    components:{
        UilEdit,
        UilTrashAlt,
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

        editItem(id){
            this.categ_edit = this.$c(this.list_categories).where('id', id).first()
            this.categ_edit_id = this.categ_edit.id
            this.popup_new = true
            this.form.name = this.categ_edit.name
            this.form.category_id = this.categ_edit.category_id
        },
        
        deleteItem(id){
            this.delete_categ = this.$c(this.list_categories).where('id', id).first()
            if (this.delete_categ.products.length > 0) {
                
                this.$vs.dialog({
                    color: "danger",
                    title: 'Família',
                    text: 'A família contem produtos, para excluir a família deve se desvincular os produtos dela.',
                    acceptText: "Ok",
                    accept: ()=>{}
                })

            }else{
                this.$vs.dialog({
                    type: "confirm",
                    color: "danger",
                    title: `Confirme`,
                    text:
                    "Deseja excluir a Família " + this.delete_categ.name + "?",
                    accept: this.acceptDelete,
                    acceptText: "Excluir",
                    cancelText: "Cancelar",
                });
            }
            
        },
        acceptDelete(){
            axios
        .delete(
          "/api/category/" + this.delete_categ.id
        )
        .then((data) => {
          this.list_categories = this.$c(this.list_categories).filter((item) => {
            return item.id !== this.delete_categ.id;
          });

          this.list_categories = this.list_categories.items;

          this.$vs.notify({
            color: "success",
            title: "Família excluída!",
            text: "",
          });
        });
        },

        record(){
            
            if (this.validation()) {

                if (this.categ_edit) {
                    axios.put('/api/category/'+this.categ_edit.id, this.form).then((resp)=>{
                        
                    this.list_categories = this.$c(this.list_categories).map((item)=>{
                        if (item.id == this.categ_edit.id) {
                            item.name = resp.data.name
                            item.category_name = resp.data.category_name
                            item.cetegory = resp.data.cetegory
                        }
                        return item
                    })
                    this.categ_edit = null
                    this.form.name = null
                    this.form.category_id = null
                    this.list_categories = this.list_categories.items
                    this.popup_new = false
                    this.$vs.notify({
                            color:'success',
                            title:'Família editada!',
                            text:''
                        })
                    })
                }else{
                    axios.post('/api/category', this.form).then((item)=>{
                    this.list_categories.push({id: item.data.id ,name: item.data.name,cetegory: item.data.cetegory,category_name: item.data.category_name, products: []})
                    this.popup_new = false
                    this.form.name = null
                    this.form.category_id = null

                    this.$vs.notify({
                            color:'success',
                            title:'Família cadastrada!',
                            text:''
                        })
                    })
                }
                
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
            axios.get('/api/category').then((item)=>{
                this.list_categories = item.data
            })
        }
        
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