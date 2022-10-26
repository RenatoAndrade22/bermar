<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ sales.length }})</span> Vendas
                </vs-navbar-title>
            </div>
            <vs-button type="relief" @click="popup_new = true">
                Cadastrar nova venda
            </vs-button>
        </vs-navbar>

        <vs-table
            stripe
            :data="list_sales"
            class="header mt-5"
            v-model="order_selected"
            @selected="handleSelected"
            @dblSelection="doubleSelection"
        >
            <template slot="thead">
                <vs-th>
                    Pedido
                </vs-th>
                <vs-th>
                    Valor
                </vs-th>
                <vs-th>
                    Comprador
                </vs-th>
                <!--
                <vs-th>
                    Status compra
                </vs-th>
                <vs-th>
                    Status pagamento
                </vs-th>
                   -->
                <vs-th>
                    Produtos
                </vs-th>
             
                <vs-th>
                    Nota fiscal
                </vs-th>
                
            </template>

            <template slot-scope="{data}">
                <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >
                    <vs-td :data="data[indextr].id">
                        {{data[indextr].id}}
                    </vs-td>

                    <vs-td :data="data[indextr].total">
                        {{ formatCurrency(data[indextr].total) }}
                    </vs-td>

                    <vs-td :data="data[indextr].enterprise.name">
                        {{data[indextr].enterprise.name}}
                    </vs-td>

                    <vs-td :data="data[indextr].sale_order_items">
                        <vs-button type="relief" @click="viewProducts(data[indextr].sale_order_items)">
                            <span>Produtos</span>
                        </vs-button>
                    </vs-td>

                    <vs-td :data="data[indextr].invoices">
                        <div v-if="data[indextr].invoices.length === 0">
                            <div @click="[upload_file = true, sale_order_id = data[indextr].id]">
                                <UilCloudUpload size="19px" color="#e85d04" />
                                <span>Enviar</span>
                            </div>
                        </div>
                        <div v-if="data[indextr].invoices.length !== 0">
                            <div @click="downloadInvoice(data[indextr].id)">
                                <UilCloudDownload size="19px" color="#76c893" />
                                <span>Baixar</span>
                            </div>
                        </div>
                    </vs-td>

                </vs-tr>
            </template>
        </vs-table>
        <vs-popup title="Enviar nota fiscal" :active.sync="upload_file">
            <h1>{{sale_order_id}}</h1>
            <vs-upload automatic text="Upload nota fiscal" fileName="file" :action="'/api/upload-invoice/'+sale_order_id" />
        </vs-popup>

        <vs-popup title="Produtos" :active.sync="view_products">
            <ul class="sale_products">
                <li v-for="(p, i) in sale_products">
                    <p>{{ p.product.name }}</p>
                    <span>{{ p.quantity }} x {{ p.price }}</span>
                </li>
            </ul>
        </vs-popup>

        <vs-popup title="Cadastrar nova venda" :active.sync="popup_new">

             <vs-row id="cadastro_venda">

                <vs-col vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Empresa</p>
                        <vs-select
                            v-model="form.company"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in companies" />
                        </vs-select>
                    </div>
                    <span class="error" v-if="error && !form.company">{{error}}</span>
                </vs-col>

                <template v-if="!buy_file">

                    <vs-col vs-w="12" v-if="form.company">
                        <vs-input
                            class="mb-3 mt-2"
                            placeholder="Buscar produto"
                            v-model="form.search"
                            danger-text="Esse campo é obrigatório"
                        />
                    </vs-col>

                    <div class="products">
                        <div v-for="(product, index) in list_products" class="product-list" v-if="form.company">
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

                </template>

                <vs-col vs-w="12">
                    <p class="total">
                        Total: {{ formatCurrency(total) }}
                    </p>
                </vs-col>

                <vs-col vs-w="12">
                    <vs-button type="relief" @click="buy_file = !buy_file">
                        <span>Cadastrar arquivo de compra</span>
                    </vs-button>
                    <vs-button type="relief"  @click="addProducts" v-if="step == 0">
                        <span>Cadastrar venda</span>
                    </vs-button>
                    <vs-button color="danger" type="filled" @click="step = 0" v-if="step == 1">
                        <span>Cancelar</span>
                    </vs-button>
                    <vs-button color="success" type="filled" @click="addSale" v-if="step == 1">
                        <span>Confirmar</span>
                    </vs-button>
                </vs-col>
             </vs-row>
        </vs-popup>

    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes } from '@iconscout/vue-unicons'
import { UploadMedia, UpdateMedia } from 'vue-media-upload';
import axios from "axios";

export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes, UploadMedia, UpdateMedia
    },
    data(){
        return{
            popup_new: false,
            error: null,
            search: null,
            order_selected: null,
            delete_product: null,
            upload_file: false,
            view_products: false,
            sale_products: [],
            sale_order_id: null,
            step: 0,
            total: 0,
            table_prices: [],
            filters:{
                status_sale: null,
                status_payment: null,
                status_delivery: null,
                invoice: null
            },
            form:{
                company: null,
                search: null,
                company_validation: false,
                products: []
            },
            buy_file: false,
            companies:[
                {
                    id: 1,
                    name: 'Empresa 1',
                },
                {
                    id: 2,
                    name: 'Empresa 2',
                },
                {
                    id: 3,
                    name: 'Empresa 3',
                },
            ],
            products: [
                {
                    id: 1,
                    name: 'Produto 1',
                    price: 100.50,
                    quantity: 0,
                },
                {
                    id: 2,
                    name: 'Produto 2',
                    price: 200.97,
                    quantity: 0,
                },
                {
                    id: 3,
                    name: 'Produto 3',
                    price: 300,
                    quantity: 0,
                },
                {
                    id: 4,
                    name: 'Produto 4',
                    price: 300,
                    quantity: 0,
                },
                {
                    id: 5,
                    name: 'Produto 5',
                    price: 300,
                    quantity: 0,
                },
                {
                    id: 6,
                    name: 'Produto 6',
                    price: 300,
                    quantity: 0,
                },
                {
                    id: 7,
                    name: 'Produto 7',
                    price: 300,
                    quantity: 0,
                },
            ],
            cart: {
                value: 0,
                products: []
            },
            sales:[
                // {
                //     id: 265,
                //     value: '1.550,00',
                //     buyer: 'Fernando',
                //     status_sale: 1,
                //     status_payment: 1,
                //     status_delivery: 1,
                //     invoice: ''
                // },
                //
                // {
                //     id: 295,
                //     value: '3.550,00',
                //     buyer: 'Fernando',
                //     status_sale: 1,
                //     status_payment: 1,
                //     status_delivery: 1,
                //     invoice: ''
                // },
                //
                // {
                //     id: 665,
                //     value: '550,00',
                //     buyer: 'Fernando',
                //     status_sale: 1,
                //     status_payment: 2,
                //     status_delivery: 3,
                //     invoice: 'link_do_arquivo'
                // },
                //
                // {
                //     id: 765,
                //     value: '1.550,00',
                //     buyer: 'Fernando',
                //     status_sale: 2,
                //     status_payment: 1,
                //     status_delivery: 2,
                //     invoice: ''
                // },
            ],
            status_delivery:[
                {text:'Preparando entrega',value:1},
                {text:'Em transito',value:2},
                {text:'Entregue',value:3},
            ],
            status_payment:[
                {text:'Pendente',value:1},
                {text:'Pago',value:2},
            ],

            status_sales:[
                {text:'Ativa',value:1},
                {text:'Cancelada',value:2},
            ],
            invoice:[
                {text:'Enviada',value:1},
                {text:'Pendente',value:2},
            ]
        }
    },
    methods:{

        viewProducts(items){
            console.log('items', items)
            this.sale_products = items
            this.view_products = true
        },

        sumQntValues(quantity, price){
            return quantity ? (parseFloat(quantity) * price) : 0
        },

        addSale(){
            //loading
            this.$vs.loading({
                container: '#cadastro_venda',
                scale: 0.6
            })

            // payload
            let sale = {
                "user_id": this.$user.id,
                "enterprise_id": this.form.company,
                "products": this.cart.products
            }

            axios.post('/api/sale', sale).then((response)=>{
                 
                 //close loading
                this.$vs.loading.close('#cadastro_venda > .con-vs-loading')

                this.popup_new = false

                this.getSaleOrders()

                this.$vs.notify({
                    color:'success',
                    title:'Venda cadastrada!',
                    text:''
                })
              
            })

           
        
        },

        getCompanies(){
            axios.get('/api/enterprises-type/2').then((data)=>{
                this.companies = data.data
            })
        },

        getProductsBermar() {
            
            axios.get("/api/products-bermar").then((data) => { 
                this.products = this.$c(data.data).map((product)=>{
                    product.quantity = 0
                    return product
                })
                this.products = this.products.items
             })
        
        },

        getTablePrices() {
            
            axios.get("/api/price_table").then((result) => { 
                this.table_prices = result.data
             })
        
        },

        addProducts(){

            if(this.form.company){

                 /* reset cart */
                this.cart.products = []

                let products = this.$c(this.list_products).filter((product)=>{
                    return product.total && product.total > 0 ? true : false
                })

                this.cart.products = products.items
                this.step = 1
            }else{
                this.error = 'Selecione uma empresa'
            }
           

        },

        getText(id, items){
            let text = this.$c(items).where('value', id).first()
            return text.text
        },

        viewItem(id){
            this.$router.push({ name: 'product_view', params: { id: id } })
        },

        editItem(id){
            this.$router.push({ name: 'product_edit', params: { id: id } })
        },

        deleteItem(id){
        },

        acceptAlert(){
        },

        handleSelected(tr) {
            console.log('handle', tr)
        },

        doubleSelection(tr) {
            console.log('double', tr)
        },

        getSaleOrders(){
            axios.get('/api/sale-order').then((resp)=>{
                this.sales = this.$c(resp.data).map((sale)=>{

                    this.$c(sale.sale_order_items).each((s)=>{
                        let value = s.quantity ? (parseFloat(s.quantity) * parseFloat(s.price)) : 0
                        sale.total = (sale.total ? sale.total : 0) + value
                    })
                    return sale
                })
                this.sales = this.sales.items
            })
        },

        downloadInvoice(sale_order_id){
            axios.get('/api/download-invoice/'+sale_order_id).then((resp)=>{
                this.$vs.notify({color: "success", title: "Arquivo baixado!", text: ""})
                window.open('/invoices/'+resp.data.name, '_blank')
            })
        },

        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        }
    },
    created() {
        this.getSaleOrders()
        this.getCompanies()
        this.getProductsBermar()
        this.getTablePrices()
    },
    watch:{
        list_products: {
            deep: true,
            handler(new_value){
                let products = this.$c(new_value).map((product)=>{
                    product.total = product.quantity ? (parseFloat(product.quantity) * product.price) : 0
                    return product
                })
                this.step = 0
                this.total = this.$c(products.items).sum('total')
            }
        }
    },
    computed:{

        list_products() {

            let products = this.$c(this.products)

            if(this.form.company){

                //empresa selecionada
                let company = this.$c(this.companies).where('id', this.form.company)
                
                // tabela referente ao Estado da empresa
                let table_price = this.$c(this.table_prices).where('name', company.items[0]['address']['state'])
                table_price = table_price.items[0].prices

                products = this.$c(this.products).map((product)=>{
                    let price = this.$c(table_price).where('product_id', product.id)
                    product.price = price.items[0].price
                    return product
                })
            }

            products = products.items

            if (this.form.search) {
                products = this.$c(products).filter((product) => {
                    return product.name.toLowerCase().search(this.form.search) >= 0;
                });
                products = products.items
            }

            return products

        },

        list_sales(){
            let sales = this.$c(this.sales)

            if (this.filters.status_sale)
                sales = sales.where('status_sale', this.filters.status_sale)

            if (this.filters.status_payment)
                sales = sales.where('status_payment', this.filters.status_payment)

            if (this.filters.status_delivery)
                sales = sales.where('status_delivery', this.filters.status_delivery)

            if (this.filters.invoice){
                if(this.filters.invoice === 1)
                    sales = sales.where('invoices', '!==', null)

                if(this.filters.invoice === 2)
                    sales = sales.where('invoices', null)
            }
            console.log('aqqqqq', sales.all())
            return sales.all()
        }
    }
}
</script>
<style scoped>
    .sale_products{
        margin: 0;
        padding: 0;
    }
    .sale_products p{
        font-weight: 600 !important;
        margin: 0;
        color: #333 !important;
    }
    .sale_products span{
        color: rgb(238, 27, 33);
    }
    .sale_products li{
        list-style: none;
        border-bottom: 1px solid #efeeee;
        padding: 15px;
    }
    .error{
        color:red
    }
    .name{
        width: 90%;
        float: left;
    }
    .number_items{
        width: 10%;
        float: left;
    }
    .form_item{
        width: 100% !important;
    }
    .products {
        background: #efee;
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
    .clear_select{
        cursor: pointer;
        margin: 21px 0px 0px 4px;
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
