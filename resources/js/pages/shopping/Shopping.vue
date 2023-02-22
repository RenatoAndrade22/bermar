<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ sales.length }})</span> Compras
                </vs-navbar-title>
            </div>
            <vs-button type="relief" @click="popup_new = true">
                Comprar
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
                    Revenda
                </vs-th>
                <vs-th>
                    Produtos
                </vs-th>
             
                <vs-th>
                    Nota fiscal
                </vs-th>

                <vs-th>
                    Boletos
                </vs-th>

                <vs-th>
                    Garantia
                </vs-th>

                <vs-th>
                    Status
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

                    <vs-td :data="data[indextr].user.name">
                        {{data[indextr].user.name}}
                    </vs-td>

                    <vs-td :data="data[indextr].sale_order_items">
                        <vs-button type="relief" @click="viewProducts(data[indextr].sale_order_items)">
                            <span>Produtos</span>
                        </vs-button>
                    </vs-td>

                    <vs-td :data="data[indextr].invoices">
                        <div v-if="data[indextr].invoices.length !== 0">
                            <div @click="downloadInvoice(data[indextr].id)">
                                <UilCloudDownload size="19px" color="#76c893" />
                                <span>Baixar</span>
                            </div>
                        </div>
                    </vs-td>

                    <vs-td :data="data[indextr].invoices">
                        <div>
                            <div @click="openModalBoletos(data[indextr].id, data[indextr].boletos)">
                                <UilBill size="19px" color="#76c893" />
                            </div>
                        </div>
                    </vs-td>

                    <vs-td :data="data[indextr].sale_order_items">
                        <vs-button type="relief" @click="warrantyProducts(data[indextr].sale_order_items)">
                            <span>Solicitar</span>
                        </vs-button>
                    </vs-td>

                    <vs-td :data="data[indextr].status">
                        <vs-button color="primary" v-if="data[indextr].status == 1" type="flat">Aprovada</vs-button>
                        <vs-button color="danger" v-if="data[indextr].status == 2" type="flat">Pendente</vs-button>
                    </vs-td>

                </vs-tr>
            </template>
        </vs-table>

        <vs-popup title="Boletos" :active.sync="upload_boleto">
        
            <div class="boletos">
                <div class="boleto" v-for="(b, i) in boletos" :key="i">
                    <div class="actions">
                        <span @click="openPdf(b.url)" style="cursor:pointer" >Abrir</span>
                    </div>
                    <iframe :src="b.url" height="200" width="200" style="cursor:pointer" />
                </div>
            </div>
        </vs-popup>

        <vs-popup title="Produtos" :active.sync="view_products">
            <ul class="sale_products">
                <li v-for="(p, i) in sale_products">
                    <p>{{ p.product.name }}</p>
                    <span>{{ p.quantity }} x {{ p.price }}</span>
                </li>
            </ul>
        </vs-popup>


        <vs-popup title="Solicitar garantia" :active.sync="list_products_warranty.length > 0" @close="closeWarranty">
            <vs-row id="record_warranty">

                <vs-col vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Cliente final</p>
                        <vs-select
                            v-model="form.user"
                            autocomplete
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in users" />
                        </vs-select>
                    </div>
                </vs-col>
                <vs-col vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Produto</p>
                        <vs-select
                            v-model="form.product"
                            autocomplete
                        >
                            <vs-select-item :key="index" :value="item.product.id" :text="item.product.name" v-for="item,index in list_products_warranty" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-w="12">
                    <vs-button type="filled" @click="record">
                        <span>Cadastrar</span>
                    </vs-button>
                </vs-col>

            </vs-row>
        </vs-popup>

        <vs-popup fullscreen title="Cadastrar nova venda" :active.sync="popup_new">
            <SaleComponent 
                :companies="companies" 
                :products="products" 
                :payment_methods="payment_methods" 
                :table_prices="table_prices"
                @products_sale="addSale"
                v-if="popup_new"
            />
        </vs-popup>
        
    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes, UilBill } from '@iconscout/vue-unicons'
import { UploadMedia, UpdateMedia } from 'vue-media-upload';
import axios from "axios";
import SaleComponent from '../../components/sale/SaleComponent'

export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes, UploadMedia, UpdateMedia, UilBill, SaleComponent
    },
    data(){
        return{
            popup_new: false,
            user: null,
            error_company: null,
            error_payment: null,
            search: null,
            order_selected: null,
            delete_product: null,
            upload_file: false,
            upload_boleto: false,
            view_products: false,
            sale_products: [],
            sale_order_id: null,
            step: 0,
            total: 0,
            list_products_warranty: [],
            table_prices: [],
            payment_methods:[],
            filters:{
                status_sale: null,
                status_payment: null,
                status_delivery: null,
                invoice: null
            },

            buy_file: false,
            companies:[
            ],
            products: [
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
            ],
            form:{
                usre: null,
                product: null
            },
            boletos: [],

            assistances: [],
            users: [],
        }
    },
    methods:{

        getAssitences(){
            axios.get('/api/enterprises-type/4').then((data)=>{
                this.assistances = data.data
            })
        },

        getUsers(){
            axios.get('/api/buyers').then((data)=>{
                this.users = data.data
            })
        },

        closeWarranty(){
            this.list_products_warranty = []
        },

        warrantyProducts(products){
            this.list_products_warranty = products
        },

        openModalBoletos(id, boletos){

            this.sale_order_id = id

            this.boletos = boletos

            this.upload_boleto = true
        },

        openPdf(pdf){
            window.open(pdf, '_blank').focus();
        },

        deleteBoleto(id){
            axios.delete('/api/boleto-delete/'+id).then((response)=>{
                this.boletos = this.$c(this.boletos).filter((item)=>{
                    return item.id != id
                })
            })
        },

        viewProducts(items){
            this.sale_products = items
            this.view_products = true
        },

        sumQntValues(quantity, price){
            return quantity ? (parseFloat(quantity) * price) : 0
        },


        addSale(data){

            //loading
            this.$vs.loading({
                container: '#cadastro_venda',
                scale: 0.6
            })

            // payload
            let sale = {

                // VENDEDOR
                "user_id": this.$user.id,

                //COMPRADOR
                "enterprise_id": data.form.company.id,

                "payment_method_id": data.form.payment_method,

                "shipping_type": data.form.frete,
                "observation": data.form.observation,
                "phone": data.form.phone,
                "status": 2,
                "shipping_company": data.form.shipping,

                "products": data.products
            }

            axios.post('/api/sale', sale).then((response)=>{
                
                //close loading
                setTimeout(() => {
                    this.$vs.loading.close("#cadastro_venda > .con-vs-loading");
                }, 1);  

                this.popup_new = false

                this.getSaleOrders()

                this.$vs.notify({
                    color:'success',
                    title:'Compra cadastrada!',
                    text:''
                })

                this.products = this.$c(this.products).map((item)=>{
                    item.discount = 0
                    item.price = 0
                    item.quantity = 0
                    item.total_discount = 0
                    item.total = 0
                    return item
                }).all()
            
            })
        },

        record(){

            //loading
            this.$vs.loading({
                container: '#record_warranty',
                scale: 0.6
            })

            if(this.validation())
            {
                axios.post('/api/warranty', this.form).then((item)=>{

                    //close loading
                    setTimeout(() => {
                        this.$vs.loading.close("#cadastro_venda > .con-vs-loading");
                    }, 1);         

                    this.list_products_warranty = []

                    this.$vs.notify({
                        color:'success',
                        title:'Garantia cadastrada!',
                        text:''
                    })
                })

            }else{
                //close loading
                setTimeout(() => {
                    this.$vs.loading.close("#cadastro_venda > .con-vs-loading");
                }, 1);  
            }
        },

        validation(){
            let v = true

            if(!this.form.user || !this.form.product){
                v = false
            }

            return v
        },

        getCompanies(){
            this.companies = [this.$user.enterprise]
        },

        getPaymentMethods(){
            axios.get('/api/payment-methods').then((data)=>{
                this.payment_methods = data.data
            })
        },
        
        getProductsBermar() {
            
            axios.get("/api/products-bermar").then((data) => { 
                this.products = this.$c(data.data).map((item)=>{
                    item.discount = 0
                    item.price = 0
                    item.quantity = 0
                    item.total_discount = 0
                    item.total = 0
                    return item
                }).all()
      
             })
        
        },

        getTablePrices() {
            
            axios.get("/api/price_table").then((result) => { 
                this.table_prices = result.data
             })
        
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


            axios.get('/api/my-shopping').then((resp)=>{
                this.sales = this.$c(resp.data).map((sale)=>{

                    this.$c(sale.sale_order_items).each((s)=>{
                        sale.total = sale.total ? sale.total : 0
                        sale.total = (parseFloat(sale.total) + parseFloat(s.total))
                    })
                    return sale
                })
                this.sales = this.sales.items
            })
        },

        downloadInvoice(sale_order_id){
            axios.get('/api/download-invoice/'+sale_order_id).then((resp)=>{
                window.open(resp.data.name, '_blank').focus();
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
        this.getPaymentMethods()
        this.getUsers()
        this.getAssitences()
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

            return sales.all()
        }
    }
}
</script>
<style scoped>

    .boletos{
        width: 100%;
        float: left;
    }

    .actions{
        width: 100%;
        float: left;
    }

    .delete{
        cursor: pointer;
        color: red;
        float: right;
        margin-right: 16px;
    }

    .boleto{
        width: 200px;
        float: left;
        margin-right: 10px;
    }
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
