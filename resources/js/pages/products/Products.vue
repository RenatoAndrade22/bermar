<template>
  <div>
    <vs-navbar class="header_page">
      <div slot="title">
        <vs-navbar-title>
          <span style="color: #ee1b21" v-if="list_products">({{ list_products.length }})</span>
          Produtos
        </vs-navbar-title>
      </div>

      <vs-input
        icon="search"
        class="search"
        placeholder="Buscar produto"
        v-model="search"
      />

      <vs-button id="cadastrar-produto" v-if="validarRegrasUsuario(1)" @click="$router.push({ name: 'products_new' })"
        >Cadastrar novo</vs-button
      >
      <vs-button v-if="!validarRegrasUsuario(1)" @click="saveLinks"
        >Salvar links</vs-button
      >
    </vs-navbar>

    <vs-table stripe :data="list_products" noDataText="Nenhum produto encontrado." class="header mt-5">
      <template slot="thead">
        <vs-th> Nome</vs-th>
      </template>

      <template slot-scope="{ data }">
        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
          <vs-td :data="data[indextr].name">
            {{ data[indextr].name }}
            <vs-input
              v-if="!validarRegrasUsuario(1)"
              class="search"
              placeholder="Link"
              v-model="data[indextr].link"
            />
          </vs-td>
          
          
          <template v-if="validarRegrasUsuario(1)">
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
            
          </template>
          
          
        </vs-tr>
      </template>

      


    </vs-table>

    <Pagination 
      :current_page="pagination.current_page" 
      :last_page="pagination.last_page" 
      :total="pagination.total" 
      @paginationClick="paginationClick"
    />

    <vs-popup title="Editar produto" :active.sync="edit_product">
      <h4>Atualizar produto.</h4>
      <template v-if="product_selected">
        <vs-row>
          <vs-col vs-w="12">
            <vs-select
              class="selectExample"
              label="Status"
              v-model="product_selected.status"
            >
              <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="item,index in optionsStatus" />
            </vs-select>
          </vs-col>
          <vs-button type="relief" class="mt-3" @click="updateProduct">
              <span>Atualizar</span>
          </vs-button>
        </vs-row>
      </template>
    </vs-popup>
    <vs-popup title="Adicionar produto" fullscreen :active.sync="select_new">
      <h4>Deseja vender um novo produto na Bermar?</h4>
      <p>
        Selecione os produtos e insira o seu estoque atual do produto para
        verder dentro da Bermar.
      </p>
      <div class="products_bermar">
        <vs-row
          class="products p-3 mb-2"
          v-for="(product, index) in products_bermar"
          :key="index"
        >

          <vs-col vs-w="1" vs-type="flex" vs-justify="center" vs-align="center">
            <div class="image">
              <span>{{product.image}}</span>
                <img v-if="product.product_images.length > 0" style="width: 100%" :src="product.product_images[0].url" />
            </div>
          </vs-col>
          <vs-col vs-w="8">
            <div class="info_delivery">
              <p class="name_product">{{ product.name }}</p>
              <!--
              <p class="desc_product">{{ product.description }}</p>
              -->
              <p>Valor: {{ product.price }}</p>
            </div>
          </vs-col>
          
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="2">
            <div class="actions">
              <vs-input
                v-model="product.stock"
                label="Estoque"
                type="number"
                class="mb-3 mt-2"
                style="width: 107px"
              />
              <vs-button type="relief" size="small"
                @click="addProduct(product.id, product.stock)"
                >Adicionar produto</vs-button
              >
            </div>
          </vs-col>
        </vs-row>
      </div>
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

import { TheMask } from "vue-the-mask";
import { Money } from "v-money";
import Investment from "../Investment";
import Pagination from '../../components/Pagination'
export default {
  name: "Products",
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
    Pagination
  },
  data() {
    return {
      search: null,
      select_new: false,
      edit_product: false,
      product_selected: null,
      delete_product: null,
      productsPerPage: 10,
      currentPage: 1,
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
      pagination:{
        current_page: 0,
        last_page: 0,
        total: 0,
      }
    };
  },
  methods: {

    paginationClick(page){
      this.getProductsBermar(page)
    },

    validarRegrasUsuario(regra){
      return this.enterpriseType.includes(regra);
    },

    saveLinks(){
      
      let links = this.$c(this.list_products).filter((item)=>{
        return item.link ? true : false
      })

      if(links.items.length > 0){
        axios.post("/api/links", links.items).then((resp) => {
          this.$vs.notify({
              color: "success",
              title: "Links salvos",
              text: "",
            });
        })
      }
    },

    updateProduct(){
      axios.put('/api/enterprise-products/'+this.product_selected.id, {product_id: this.product_selected.id, status: this.product_selected.status}).then((item)=>{
        this.$vs.notify({
          color:'success',
          title:'Produto atualizado!',
          text:''
        })
      })
      this.edit_product = false
    },
    addProduct(id, stock){
      if (stock) {
        axios.post("/api/enterprise-products", {product_id: id, stock: stock}).then((data) => {
          this.products_bermar = this.$c(this.products_bermar).map((item)=>{
            if (item.id == id) {
              item.stock = null
            }
            return item
          })
          this.$vs.notify({
            color:'success',
            title:'Estoque adicionado!',
            text:''
          })
        });
      }
    },

    getProducts() {
      axios.get("/api/enterprise-products").then((data) => {
          this.products = data.data
      });
    },

    getProductsLinks() {
      axios.get("/api/links").then((data) => {
        this.products_bermar = data.data
        
      });
    },

    getProductsBermar(page = 1) {
      axios.get("/api/products-bermar?page="+page).then((data) => {

          if (this.validarRegrasUsuario(1)) {

            this.products_bermar = this.$c(data.data.results).map((data)=>{
              data.stock = null
              return data
            })
          }else{
            this.products_bermar = this.$c(data.data.results).map((data)=>{
              data.stock = null
              return data
            })
            this.products_bermar = this.products_bermar.items
          }

          this.pagination.current_page = data.data.current_page
          this.pagination.last_page = data.data.last_page
          this.pagination.total = data.data.total_items
          
      });

    },

    viewItem(id) {
      this.$router.push({ name: "product_view", params: { id: id } });
    },

    editItem(id) {
      if (this.validarRegrasUsuario(1)) {
        this.$router.push({ name: "product_edit", params: { id: id } });
      }
      if (this.validarRegrasUsuario(2)) {
        this.edit_product = true
        this.product_selected = this.$c(this.products).where('id', id).first()
      }
    },

    deleteItem(id) {

      this.delete_product = this.$c(this.list_products).where("id", id);

      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: `Confirme`,
        text:
          "Deseja excluir o produto " + this.delete_product.items[0].name + "?",
        accept: this.acceptAlert,
        acceptText: "Excluir",
        cancelText: "Cancelar",
      });
    },

    acceptAlert() {
      axios
        .delete(
          "/api/product/" + this.delete_product.items[0].id
        )
        .then((data) => {
          this.products_bermar = this.$c(this.products_bermar).filter((item) => {
            return item.id !== this.delete_product.items[0].id;
          });

          this.products_bermar = this.products_bermar.items;

          this.$vs.notify({
            color: "success",
            title: "Produto excluído!",
            text: "",
          });
        }).catch((e)=>{
          this.$vs.notify({
            color: "danger",
            title: "Existe venda com esse produto, por isso ele não pode ser excluído, caso não queira mais esse produto, clique para editar e desative esse produto.",
            text: "",
          });
        });
    },
  },
  created() {

    if (!this.validarRegrasUsuario(1) && !this.validarRegrasUsuario(1)) {
      this.getProducts();
    }

    if (this.validarRegrasUsuario(2)) {
      this.getProductsLinks();
    }
        
    if(this.validarRegrasUsuario(1)){
      this.getProductsBermar();
    }
  },
  computed: {

    list_products() {

      let products = this.products_bermar;

      if (this.search) {

        products = this.$c(products).filter((product) => {
          return product.name.toLowerCase().search(this.search) >= 0;
        });
        products = products.items
      }else{
        products = products.items != undefined ? products.items : products
      }

      return products;
    },
    enterpriseType(){
      return this.$store.state.enterpriseType;
    }
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
