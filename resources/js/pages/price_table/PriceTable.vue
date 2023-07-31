<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                <span style="color: #ee1b21">({{ list_categories.length }})</span>
                Tabelas
                </vs-navbar-title>
            </div>

            <vs-button type="relief"  @click="$router.push({ name: 'PriceTableNew' })"
                >Cadastrar nova</vs-button
            >
        </vs-navbar>
        <vs-table stripe :data="list_categories" noDataText="Nenhuma família encontrada." class="header mt-5">
            <template slot="thead">
                <vs-th> Nome </vs-th>
                <vs-th> Ações </vs-th>
            </template>
            <template slot-scope="{ data }">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="data[indextr].name">
                        {{ data[indextr].name }}
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
                                />
                            </vs-tooltip>
                        </div>
                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>
        
    </div>
</template>
<script>
import { UilEye, UilEdit, UilTrashAlt } from "@iconscout/vue-unicons";

export default {
    name: 'PriceTable',
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
            form: {
                name: null,
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
            this.popup_new = true
            this.form.name = this.categ_edit.name
        },

        deleteItem(id){

            this.delete_categ = this.$c(this.list_categories).where('id', id).first()
        
            this.$vs.dialog({
                    type: "confirm",
                    color: "danger",
                    title: `Confirme`,
                    text:
                    "Deseja excluir a tabela " + this.delete_categ.name + "?",
                    accept: this.acceptDelete,
                    acceptText: "Excluir",
                    cancelText: "Cancelar",
            });
            
            
        },
        acceptDelete(){
            axios.delete("/api/price_table/" + this.delete_categ.id).then((data) => {
            this.list_categories = this.$c(this.list_categories).filter((item) => {
                return item.id !== this.delete_categ.id;
            });

            this.list_categories = this.list_categories.items;

            this.$vs.notify({
                color: "success",
                title: "Tabela excluída!",
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
                        }
                        return item
                    })
                    this.categ_edit = null
                    this.form.name = null
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
                    this.list_categories.push({id: item.data.id ,name: item.data.name, products: []})
                    this.popup_new = false
                    this.form.name = null
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
            console.log('validation', this.form.name)

            if (!this.form.name) {
                i = false
                this.form.name_validation = true
            }else{
                this.form.name_validation = false
            }

            return i
        },

        getTables(){
            axios.get('/api/price_table').then((item)=>{
                this.list_categories = item.data
            })
        }
        
    },
    created(){
        this.getTables()
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
</style>