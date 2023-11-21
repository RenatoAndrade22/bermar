<template>
    <div id="page_sales">
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ sales.length }})</span> Vendas
                </vs-navbar-title>
            </div>
            <vs-input
                icon="search"
                class="search"
                placeholder="Buscar por cnpj"
                v-model="search_cnpj"
                v-mask="'##.###.###/####-##'"
            />
            <vs-button type="relief" @click="[popup_new = true, sale_edit_id = null]">
                Cadastrar nova venda
            </vs-button>
            
        </vs-navbar>

    <VueHtml2pdf
                :show-layout="false"
                :float-layout="true"
                :enable-download="true"
                :preview-modal="true"
                :paginate-elements-by-height="1400"
                filename="myPDF"
                :pdf-quality="2"
                :manual-pagination="false"
                pdf-format="a4"
                pdf-orientation="landscape"
                pdf-content-width="100%"
                ref="html2Pdf"
            >


        
                <section slot="pdf-content">
                    
                    <div class="pdf_sale" v-if="sale_pdf">
                        <vs-row class="header_pdf">

                            <vs-col vs-w="2" >
                                <img src="/images/logo.png" style="width:100%; padding-right: 25px;">
                            </vs-col>

                            <vs-col vs-w="2" >
                                <p>N° do Pedido: <span>{{ sale_pdf.id }}</span></p>
                            </vs-col>

                            <vs-col vs-w="5" >
                                <h4 style="font-size: 16px;margin: 0;font-weight: 600;">Pedido de venda</h4>
                                <p style="margin: 0;">Empresa: <span>0101 BERMAR INDUSTRIA E COMERCIO LTDA</span></p>
                                <p style="margin: 0;">Filial: <span>1 BERMAR INDUSTRIA E COMERCIO LTDA</span></p>
                            </vs-col>

                            <vs-col vs-w="3" >
                                <p style="margin: 0;">Data: <span>{{ sale_pdf.CreatedAtBr }}</span></p>
                                <p>Prevs. entrega: <span>{{ sale_pdf.deliveryDateBr }}</span></p>
                            </vs-col>
<!--
 <vs-col vs-w="5" >
                                <p>Número Pedido: <span>{{ sale_pdf.id }}</span></p>
                                <p>Data emissão: <span>{{ dateFormat(sale_pdf.created_at) }}</span></p>
                                <p>Razão Social: <span>{{ sale_pdf.enterprise.name }}</span></p>
                                <p>CNPJ: <span>{{ sale_pdf.enterprise.cnpj }}</span></p>
                                <p v-if="sale_pdf.enterprise.address.length > 0">Endereço: <span>{{ sale_pdf.enterprise.address[0].street }}, {{ sale_pdf.enterprise.address[0].number }}, {{ sale_pdf.enterprise.address[0].district }}, {{ sale_pdf.enterprise.address[0].city }} - {{ sale_pdf.enterprise.address[0].state }}</span></p>
                                <p>Representante: <span>{{ sale_pdf.user.name }}</span></p>
                            </vs-col>

                            <vs-col vs-w="5" >
                                <p>Condição de Pagamento: <span>{{ sale_pdf.name }}</span></p>
                                <p>Transportadora: <span>{{ sale_pdf.shipping_company }}</span></p>
                                <p>Tipo de Frete : <span>{{ sale_pdf.shipping_type }}</span></p>
                                <p>Data de emissão: <span>{{ sale_pdf.delivery_date }}</span></p>
                                <p>Previsão de entrega: <span>{{ sale_pdf.created_at }}</span></p>
                                <p>Observação: <span>{{ sale_pdf.observation }}</span></p>
                            </vs-col>

--> 
                           
                        </vs-row>
                        <vs-row class="mt-2">
                            <vs-col vs-w="6" >
                                <p style="margin: 0;">{{ sale_pdf.enterprise.code_integration }} {{ sale_pdf.enterprise.name }}</p>

                                <template v-if="sale_pdf.enterprise.address.length > 0">
                                    <p>Endereço: <span>{{ sale_pdf.enterprise.address[0].street }}, {{ sale_pdf.enterprise.address[0].number }}</span></p>
                                    <p>Bairro: <span>{{ sale_pdf.enterprise.address[0].district }}</span></p>
                                </template>
                            </vs-col>
                            <vs-col vs-w="3" >

                                <p>CNPJ: <span>{{ cnpj(sale_pdf.enterprise.cnpj) }}</span></p>

                                <template v-if="sale_pdf.enterprise.address.length > 0">
                                    <p>Complemento: <span>{{ sale_pdf.enterprise.address[0].complement }}</span></p>
                                    <p>Cidade: <span>{{ sale_pdf.enterprise.address[0].city }}</span> &nbsp;&nbsp; | &nbsp;&nbsp; CEP: <span>{{ sale_pdf.enterprise.address[0].zipcode }}</span> </p>
                                </template>
                               
                            </vs-col>
                            <vs-col vs-w="3" >
                                <p>Telefone: <span>{{ sale_pdf.enterprise.phone }}</span></p>
                                <template v-if="sale_pdf.enterprise.address.length > 0">
                                    <p>Complemento: <span>{{ sale_pdf.enterprise.address[0].complement }}</span></p>
                                </template>
                            </vs-col>

                            <vs-col vs-w="6" >
                                <p>Vendedor: <span>{{ sale_pdf.user.code_integration }} {{ sale_pdf.user.name }}</span></p>
                                <p>Transportador: <span>{{ sale_pdf.carrier.code_integration }} {{ sale_pdf.carrier.name }}</span></p>
                                <p>T. redespacho: <span>{{ sale_pdf.shipping_type_redispatch }}</span></p>
                            </vs-col>
                            <vs-col vs-w="3" >
                                <p>&nbsp; </p>
                                <p>Frete: <span>{{ sale_pdf.shipping_type }}</span> &nbsp; &nbsp; &nbsp; &nbsp;  Qtd. volumes: <span>{{ sale_pdf.volume }}</span></p>
                            </vs-col>
                            
                            <vs-col vs-w="3" >
                                <p>&nbsp; </p>
                                <p>Valor cobrado na NF: <span>{{ sale_pdf.value_NF }}</span></p>
                            </vs-col>
                        </vs-row>



                        <vs-table
                        :data="sale_pdf.sale_order_items"
                        id="list-products"
                    >
                        <template slot="thead">
                            <vs-th>
                                Produto
                            </vs-th>
            
                            <vs-th>
                                Quantidade
                            </vs-th>
                            
                            <vs-th>
                                Vl. Unitário
                            </vs-th>

                            <vs-th>
                                Porcentagem de desconto
                            </vs-th>

                            <vs-th>
                                Total do produto
                            </vs-th>

                        </template>
            
                        <template slot-scope="{data}">
                            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >

                                <vs-td :data="data[indextr].product.name">
                                    {{data[indextr].product.integration_code}} &nbsp;&nbsp; {{data[indextr].product.name}}
                                </vs-td>

                                <vs-td :data="data[indextr].quantity">
                                    {{data[indextr].quantity}}
                                </vs-td>

                                <vs-td :data="data[indextr].quantity">
                                    {{ formatCurrency(data[indextr].price) }}
                                </vs-td>

                                <vs-td :data="data[indextr].discount_percentage">
                                    {{data[indextr].discount_percentage}}
                                </vs-td>

                                <vs-td :data="data[indextr].value">
                                    {{ data[indextr].total }}
                                </vs-td>

                            </vs-tr>
                        </template>
                    </vs-table>


                        <vs-row>
                            <vs-col vs-w="4" >
                                <p v-if="sale_pdf.payment_term">Cond. Recebimento: <span>{{ sale_pdf.payment_term.name }}</span></p>
                            </vs-col>
                            <vs-col vs-w="4" >
                                <p>R$ Desconto: <span>{{ formatCurrency(sale_pdf.valueFull - sale_pdf.value) }}</span></p>
                            </vs-col>
                            <vs-col vs-w="4" >
                                <p>Total do pedido: <span>{{ formatCurrency(sale_pdf.value) }}</span></p>
                            </vs-col>
                            <vs-col vs-w="12" >
                                <p>Observações: {{ sale_pdf.observation }}</p>
                            </vs-col>
                        </vs-row>
                    </div>
                </section>

 </VueHtml2pdf> 


            
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
                
                <!-- <vs-th>
                    Representante
                </vs-th> -->
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

                <vs-th>
                    Status
                </vs-th>

                <vs-th>
                    PDF
                </vs-th>

                <vs-th>
                    #
                </vs-th>
                
            </template>

            <template slot-scope="{data}">
                <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >
                    <vs-td :data="data[indextr].id">
                        {{data[indextr].id}}
                    </vs-td>

                    <vs-td :data="data[indextr].total">
                        {{ formatCurrency(data[indextr].value) }}
                    </vs-td>

                    <vs-td :data="data[indextr].enterprise.name">
                        {{data[indextr].enterprise.name}}
                    </vs-td>

                    <!-- <vs-td :data="data[indextr].enterprise.name">
                        {{data[indextr].enterprise.name}}
                    </vs-td> -->

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

                    <vs-td :data="data[indextr]">
                        <vs-button @click="statusOpen(data[indextr].status, data[indextr].id)" color="primary" v-if="data[indextr].status == 1" type="flat">Aprovada</vs-button>
                        <vs-button @click="statusOpen(data[indextr].status, data[indextr].id)" color="danger" v-if="data[indextr].status == 2" type="flat">Pendente</vs-button>
                    </vs-td>

                    <vs-td>
                        <vs-button type="relief" @click="pdfGenerate(data[indextr])">
                            <span>Baixar</span>
                        </vs-button>
                    </vs-td>
                    
                    <vs-td>
                        <vs-button type="relief" @click="editSale(data[indextr])">
                            <span>Editar</span>
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
                    <span>{{ p.quantity }} x {{ p.price }} | {{ p.discount_percentage }}% de desconto | Código do produto: {{ p.id }}</span>
                </li>
            </ul>
        </vs-popup>

        <vs-popup fullscreen title="Cadastrar nova venda" :active.sync="popup_new">
            
            <SaleComponent 
                :payment_terms="payment_terms"
                :products="products" 
                :payment_methods="payment_methods" 
                :table_prices="table_prices"
                :carriers="carriers"
                :sale_edit="sale_edit"
                @products_sale="addSale"
                v-if="popup_new"
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

        <vs-popup title="Atualizar status" :active.sync="update_status">
            <vs-select v-model="update_status_value">
                <vs-select-item key="aprovado" value="1" text="Aprovado" />
                <vs-select-item key="pendente" value="2" text="Pendente" />
            </vs-select>
            <ButtonComponent
                v-model="active_load" 
                id_loadding="page_sales" 
                name_button="Atualizar" 
                @send="updateStatus"
                class="mt-3"
                style="text-align: right;"
            />
        </vs-popup>

    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes, UilBill, ButtonLoadding } from '@iconscout/vue-unicons'
import { UploadMedia, UpdateMedia } from 'vue-media-upload'
import axios from "axios"
import SaleComponent from '../../components/sale/SaleComponent'
import ButtonComponent from '../../components/ButtonLoadding'
import {mask} from "vue-the-mask";
import VueHtml2pdf from 'vue-html2pdf'
import moment from 'moment';

export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes, UploadMedia, UpdateMedia, UilBill,
        SaleComponent, ButtonComponent, VueHtml2pdf
    },
    directives: {mask},
    data(){
        return{
            sale_pdf: null,
            search_cnpj: null,
            active_load: false,
            update_status_value: null,
            update_status_id: null,
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
            update_status: false,
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
            sales:[],
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
            payment_terms: [],
            carriers: [],
            sale_edit: {},
            sale_edit_id: null,
        }
    },

    methods:{

        editSale(s){
           this.sale_edit_id = s.id
            axios.get('/api/sale-all-info/'+s.id).then((resp)=>{
                this.sale_edit = resp.data
                this.popup_new = true

            })
        },

        cnpj(cnpj){
            // Remove todos os caracteres que não são dígitos
            cnpj = cnpj.replace(/\D/g, '')

            // Verifica se o CNPJ possui 14 dígitos após a remoção dos não numéricos
            if (cnpj.length !== 14) {
                return false
            }

            cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5')

            return cnpj
        },

        calcPriceProduct(quantidade, precoFinal){
            return precoFinal / quantidade// preço original por unidade
        },

        dateFormat(data){
            let dataObj = new Date(data);
            let dia = dataObj.getDate();
            let mes = dataObj.getMonth() + 1;
            let ano = dataObj.getFullYear();

            // adiciona zero à esquerda se o dia ou mês tiver apenas um dígito
            if (dia < 10) {
            dia = "0" + dia;
            }
            if (mes < 10) {
            mes = "0" + mes;
            }

            let dataFormatada = dia + "/" + mes + "/" + ano;

            return dataFormatada
        },

        generateReport () {
            this.$refs.html2Pdf.generatePdf()
        },

        

        pdfGenerate(s){
            this.sale_pdf = s
            this.generateReport()
        },

        statusOpen(status, sale_order_id){
            this.update_status_id = sale_order_id
            this.update_status_value = status
            this.update_status = true
        },

        updateStatus(){

            this.active_load = true
            axios.post('/api/approve-sale/'+this.update_status_id, {
                status: this.update_status_value,
            }).then((data)=>{

                if(data.data != "error"){
                    this.update_status = false
                    this.active_load = false
                    this.$vs.notify({
                        color:'success',
                        title:'Venda cadastrada com sucesso!',
                        text:''
                    })
                    this.getSaleOrders()
                }else{
                    // Erro na solicitação
                    this.update_status = false;
                    this.active_load = false;
                    this.$vs.notify({
                        color: 'danger',
                        title: 'Erro ao cadastrar a venda.',
                        text: '' 
                    });
                }
                
            }).catch((error) => {
                // Erro na solicitação
                this.update_status = false;
                this.active_load = false;
                this.$vs.notify({
                    color: 'danger',
                    title: 'Erro ao cadastrar a venda.',
                    text: '' 
                });
            });
        },

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

            console.log('data.form',  data.form)
            // payload
            let sale = {

                // VENDEDOR
                "user_id": this.$user.id,

                //COMPRADOR
                "enterprise_id": data.form.company,

                "payment_method_id": data.form.payment_method,

                "delivery_date": data.form.delivery_date,
                "observation": data.form.observation,
                "status": 2,
                "payment_term": data.form.payment_term,


                "shipping_type": data.form.frete,
                "carrier": data.form.carrier,
                "phone": data.form.phone,

                "shipping_type_redispatch": data.form.frete_redispatch,
                "carrier_redispatch": data.form.carrier_redispatch,
                "phone_redispatch": data.form.phone_redispatch,

                "products": data.products,
                "table_price_id": data.form.table_price,
                "value_NF": data.form.value_nf,
                "volume": data.form.volume,
                "sale_edit_id": this.sale_edit_id

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
                    title:'Venda cadastrada!',
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

        /*
        getCompanies(){
            axios.get('/api/enterprises-type/2').then((resp)=>{

                let data

                // ADMIN
                if(this.$user.enterprise.enterprise_type_id == 1){
                    data = resp.data
                }

                // REVENDA
                if(this.$user.enterprise.enterprise_type_id == 2){
                    data = this.$c(resp.data).filter((item)=>{
                        return item.id == this.$user.enterprise.id
                    }).all()
                }

                // REPRESENTANTE
                if(this.$user.enterprise.enterprise_type_id == 3){
                    data = this.$c(resp.data).filter((item)=>{
                        return item.enterprise_id == this.$user.enterprise.id
                    }).all()
                }

                this.companies = data
            })
        },
        */
        getPaymentMethods(){
            axios.get('/api/payment-methods').then((data)=>{
                this.payment_methods = data.data
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
        },

        doubleSelection(tr) {
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
                
                this.sales = resp.data
            })
        },

        downloadInvoice(sale_order_id){
            axios.get('/api/download-invoice/'+sale_order_id).then((resp)=>{
                window.open(resp.data.name, '_blank').focus();
            })
        },

        formatCurrency(value){
            return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value)
        },

        getPaymentTerms(){
            axios.get('/api/payment-terms').then((resp)=>{
                this.payment_terms = resp.data
            })
        },

        

        getCarriers(){
            axios.get('/api/carriers').then((resp)=>{
                this.carriers = resp.data
            })
        }
    },
    created() {
        this.getSaleOrders()
        this.getPaymentTerms()
        this.getCarriers()
        this.getTablePrices()
        this.getPaymentMethods()
        this.getAssitences()
        this.getUsers()
    },
   
    computed:{
        
/*
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
*/
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
            
            if(this.search_cnpj){
                sales = this.$c(sales.all()).filter((item)=>{
                    return item.enterprise.cnpj.search(this.search_cnpj) >= 0 || item.user.enterprise.cnpj.search(this.search_cnpj) >= 0
                })
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
    #list-products{
        margin: 10px 0;
    }
    #list-products th{
        padding: 0px !important;
        padding-right: 10px !important;
    }
    #list-products td{
        padding: 0px !important;
        padding-right: 10px !important;
        border-bottom: 1px solid #777;
    }
    .pdf_sale{
        width: 100%;
        padding: 50px;
        z-index: 99999;
        margin: 0 auto;
        background: #fff;
    }
    .pdf_sale p{
        color: #000 !important;
        margin: 0;
        font-weight: 600 !important;
        font-size: 12px !important;
    }
    .pdf_sale p span{
        color: #000 !important;
        font-weight: 300;
    }
    .product_pdf{
        border: 1px solid #efeeee;
        padding: 20px;
    }
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
