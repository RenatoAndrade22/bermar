<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ sales.length }})</span> Vendas
                </vs-navbar-title>
            </div>
            <vs-button type="relief" v-if="$user.enterprise.enterprise_type_id != 1" @click="popup_new = true">
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
                    Revenda
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
             
                <vs-th v-if="[1, 2].includes(user.enterprise.enterprise_type_id)">
                    Nota fiscal
                </vs-th>

                <vs-th v-if="[1,2].includes(user.enterprise.enterprise_type_id)">
                    Boletos
                </vs-th>

                <vs-th>
                    Garantia
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

                    <vs-td :data="data[indextr].invoices" v-if="[1,2].includes(user.enterprise.enterprise_type_id)">
                        <div v-if="data[indextr].invoices.length === 0 && [1].includes(user.enterprise.enterprise_type_id)">
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

                    <vs-td :data="data[indextr].invoices" v-if="[1,2].includes(user.enterprise.enterprise_type_id)">
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

                </vs-tr>
            </template>
        </vs-table>
        <vs-popup title="Enviar nota fiscal" :active.sync="upload_file">
            <vs-upload automatic text="Upload nota fiscal" fileName="file" :action="'/api/upload-invoice/'+sale_order_id" />
        </vs-popup>

        <vs-popup title="Enviar boleto" :active.sync="upload_boleto">
            <vs-upload automatic text="Upload boleto" fileName="file" :action="'/api/upload-boleto/'+sale_order_id" />
        
            <div class="boletos">
                <div class="boleto" v-for="(b, i) in boletos" :key="i">
                    <div class="actions">
                        <span @click="openPdf(b.url)" style="cursor:pointer" >Abrir</span>
                        <span @click="deleteBoleto(b.id)" class="delete">x</span>
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

        <vs-popup fullscreen title="Cadastrar nova venda" :active.sync="popup_new">
            <SaleComponent 
                :companies="companies" 
                :products="products" 
                :payment_methods="payment_methods" 
                :table_prices="table_prices"
            />
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

    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes, UilBill } from '@iconscout/vue-unicons'
import { UploadMedia, UpdateMedia } from 'vue-media-upload'
import axios from "axios"
import SaleComponent from '../../components/sale/SaleComponent'
export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes, UploadMedia, UpdateMedia, UilBill,
        SaleComponent
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
            table_prices: [],
            payment_methods:[],
            filters:{
                status_sale: null,
                status_payment: null,
                status_delivery: null,
                invoice: null
            },
            form:{
                user: null,
                product: null,
            },
            users: [],
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
            boletos: [],
            list_products_warranty: [],
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
                        this.$vs.loading.close("#record_warranty > .con-vs-loading");
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
                    this.$vs.loading.close("#record_warranty > .con-vs-loading");
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
                "payment_method_id": this.form.payment_method,
                "products": this.cart.products
            }

            axios.post('/api/sale', sale).then((response)=>{
                 
                 //close loading
                 setTimeout(() => {
                    this.$vs.loading.close("#record_warranty > .con-vs-loading");
                }, 1);  

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

        getPaymentMethods(){
            axios.get('/api/payment-methods').then((data)=>{
                this.payment_methods = data.data
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

            if(this.form.company && this.form.payment_method){

                 /* reset cart */
                this.cart.products = []

                let products = this.$c(this.list_products).filter((product)=>{
                    return product.total && product.total > 0 ? true : false
                })

                this.cart.products = products.items
                this.step = 1

            }else{

                if(this.form.company){
                    this.error_company = 'Selecione uma empresa'
                }
                
                if(this.form.payment_method){
                    this.error_payment = 'Selecione uma empresa'
                }
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

            if (localStorage.user) {
                this.user = JSON.parse(localStorage.user);
            }

            let url

            if(this.user.enterprise.enterprise_type_id == 1){
                url = 'all-sale-orders'
            }else{
                url = 'sale-order'
            }

            axios.get('/api/'+url).then((resp)=>{
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
        this.getAssitences()
        this.getUsers()
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
