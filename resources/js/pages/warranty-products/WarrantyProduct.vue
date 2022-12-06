<template>
  <div>
    <vs-navbar class="header_page">
      <div slot="title">
        <vs-navbar-title>
          <span style="color: #ee1b21">({{ list_products.length }})</span>
          Produtos de garantia
        </vs-navbar-title>
      </div>

      <vs-input
        icon="search"
        class="search"
        placeholder="Buscar produto"
        v-model="search"
      />
      <vs-button v-if="$user.enterprise.enterprise_type_id == 2" type="relief" @click="select_new = !select_new"
        >Produtos</vs-button
      >

      <vs-button v-if="$user.enterprise.enterprise_type_id == 1" type="relief" @click="popup_new = true"
        >Cadastrar novo</vs-button
      >
    </vs-navbar>

    <vs-table stripe :data="list_products" noDataText="Nenhum produto encontrado." class="header mt-5">
      <template slot="thead">
        <vs-th> Nome </vs-th>
        <vs-th> Preço </vs-th>
        <vs-th> Status </vs-th>
        <vs-th> Ações </vs-th>
      </template>

      <template slot-scope="{ data }">
        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
          <vs-td :data="data[indextr].name">
            {{ data[indextr].name }}
          </vs-td>

          <vs-td :data="data[indextr].price">
            {{ data[indextr].price }}
          </vs-td>

          <vs-td :data="data[indextr].status">
            <vs-button
              v-if="data[indextr].status == 1"
              line-origin="left"
              color="success"
              type="flat"
              >Ativo</vs-button
            >
            <vs-button
              v-if="data[indextr].status == 0"
              line-origin="left"
              color="danger"
              type="flat"
              >Inativo</vs-button
            >
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

    <vs-popup :title="edit_product ? 'Editar produto' : 'Cadastrar produto'" :active.sync="popup_new">
            <vs-row vs-w="12" style="width: 100% !important; display: block;">
                
                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <div style="width: 95%;height: 80px;">
                        <p class="text-label">Razão Social</p>
                        <vs-input
                            :danger="form.name_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Razão Social"
                            v-model="form.name"
                        />
                    </div>
                </vs-col>
      

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Status</p>
                        <vs-select
                            v-model="form.status"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in status" />
                        </vs-select>
                    </div>
                </vs-col>

                

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Preço</p>
                        <vs-input
                            v-if="money_active"
                            :danger="form.price_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Preço"
                            v-model="form.price"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="left" vs-align="left" vs-w="6" >
                    <div class="mt-1">
                        <vs-button type="relief" @click="record" style="margin-left: 14px;">
                        <span v-if="!edit_product">Cadastrar</span>
                        <span v-if="edit_product">Editar</span>
                    </vs-button>
                    </div>
                </vs-col>

               
            </vs-row>
    </vs-popup>
    

  </div>
</template>

<script>
import {
  BRow,
  BCol,
  BTable,
  BButton,
  BFormInput,
  BFormGroup,
} from "bootstrap-vue";
import { UilEye, UilEdit, UilTrashAlt } from "@iconscout/vue-unicons";
import {VMoney} from 'v-money'

import { TheMask } from "vue-the-mask";
import { Money } from "v-money";
import Investment from "../Investment";

export default {
  name: "WarrantyProducts",
  components: {
    BRow,
    BCol,
    BTable,
    BButton,
    BFormInput,
    BFormGroup,
    UilEye,
    UilEdit,
    UilTrashAlt,
  },
  directives: {money: VMoney},
  data() {
    return {
        search: null,
        select_new: false,
        edit_product: null,
        product_selected: null,
        delete_product: null,
        popup_new: false,
        money_active: false,
        form:{
            id: null,
            name: null,
            name_validation: false,
            status: 1,
            price: "55",
            price_validation: false
        },
        status:[
            {
                id: 0,
                name: "Inativo",
            },
            {
                id: 1,
                name: "Ativo",
            },
        ],
        optionsStatus:[
            {
                text:'Ativo',
                value:1
            },
            {
                text:'Inativo',
                value:0
            },
        ],
        products: [
        ],
        products_bermar: [
        ],
        money: {
            decimal: ',',
            thousands: '.',
            precision: 2,
            masked: false /* doesn't work with directive */
        }
    };
  },
  methods: {

    record(){
        if(this.validation()){
            if(!this.edit_product){
                axios.post("/api/warranty-product", this.form).then((data) => {
                    this.getProducts()
                    this.popup_new = false
                    this.$vs.notify({
                        color:'success',
                        title:'Produto cadastrado!',
                        text:''
                    })
                })
            }else{
                axios.put("/api/warranty-product", this.form).then((data) => {
                    this.edit_product =  false
                    this.getProducts()
                    this.popup_new = false
                    this.$vs.notify({
                        color:'success',
                        title:'Produto cadastrado!',
                        text:''
                    })
                })
            }

        }
    },

    validation(){
        let i = true

        this.form.price = this.form.price.replace(".", "")
        this.form.price = parseFloat(this.form.price.toString().replace(",", "."))

        this.form.name_validation = !this.form.name ? true : false
        if(!this.form.name)                
            i = false

        this.form.price_validation = !this.form.price ? true : false
        if(!this.form.price)                
            i = false

        return i
    },

    editItem(id) {
        this.edit_product =  true
        let product = this.$c(this.products).where('id', id).first()
        this.form.name = product.name
        this.form.status = product.status
        this.popup_new = true
    },

    getProducts() {
      axios.get("/api/warranty-product").then((data) => {
          this.products = data.data
      });
    },
  },
  created() {
    this.getProducts();
    this.money_active = true
  },
  computed: {
    list_products() {
      let products = this.products;

      if (this.search) {
        products = this.$c(products).filter((product) => {
          return product.name.toLowerCase().search(this.search) >= 0;
        });
        products = products.items
      }

      return products;
    },
  },
};
</script>

<style>
.products {
  background: #efee;
}
.products_bermar p {
  margin: 0;
}
.products_bermar .name_product{
    font-weight: 600 !important;
    font-size: 15px !important;
}
.info_delivery {
  padding: 8px 16px;
}
.icons {
  float: left;
}
.icon_view {
  cursor: pointer;
}
.input-span-placeholder {
  margin-top: 4px;
  margin-left: 6px;
}
.vs-dialog-accept-button {
  background: #ff4757;
  padding: 7px 10px;
  color: #ffffff;
  border-radius: 8px;
  margin: 10px;
  cursor: pointer;
}
.vs-dialog-cancel-button {
  margin: 10px;
  cursor: pointer;
}
.vs-dialog-text {
  padding: 25px 20px;
}
</style>
<style scoped>
.header_page {
  padding: 20px 10px;
}
.header_page h3 {
  font-size: 20px;
  font-weight: 600;
}
.search {
  margin-right: 20px;
}
</style>
