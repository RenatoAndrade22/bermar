<template>
    <div id="home_dashboard">
        <b-row>
            <template v-if="[3].includes(user_type)">
                <b-col>
                    <div class="card_column">
                        <h1>{{ total_sales }}</h1>
                        <p>Pedidos do mês</p>
                    </div>
                </b-col>
                <b-col>
                    <div class="card_column">
                        <h1>R$ {{ financial_total }}</h1>
                        <p>Em vendas no mês</p>
                    </div>
                </b-col>
            </template>

            <template v-if="[1].includes(user_type)">
                <div class="card_column">
                    <b-row class="text-center">
                        <b-col md="6">
                            <h1>Catalogo</h1>
    
                            <p style="cursor:pointer;" @click="chooseFiles">Atualizar catalogo</p>
                            
                            <input id="fileUploadCatalogo" type="file" accept=".pdf" v-on:change="onFileChange" hidden>
                            <iframe :src="url_pdf" height="200" width="200" />
    
                            <p style="cursor: pointer;font-size: 15px !important;font-weight: bold !important;margin-top: 10px;" @click="sendCatalog" v-if="active_send">Enviar</p>
                        </b-col>
                        <b-col md="6">
                            <h1>Atualizar banco de dados</h1>
                            <vs-button size="small" @click="getDataApi">
                                Buscar dados na API
                            </vs-button>
                            <h3 class="mt-3" v-if="message_external_import">{{ message_external_import }}</h3>

                            <div class="product_integration">
                                <p v-for="(p, i) in product_integration" :key="i">
                                    Importar produtos do grupo: {{ p.code_integration }} <span @click="delelteIntegration(p.id)">x</span>
                                </p>
                                <vs-input
                                    style="width: 160px !important; float:left;"
                                    placeholder="Codigo do grupo"
                                    v-model="group_product"
                                />
                                <vs-button 
                                    size="small" 
                                    @click="recordIntegration"
                                    style="float: left;margin-left: 10px;margin-top: 3px;"
                                >
                                    Cadastrar
                                </vs-button>
                            </div>

                        </b-col>
                    </b-row>
                </div>
            </template>
            
        </b-row>

    </div>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import Chart from '../components/Chart'

export default {

    components:{
        BRow, BCol, Chart
    },
    data(){
        return{
            form:{
                url_catalog: null
            },
            message_external_import: null,
            active_send: false,
            total_sales: 0,
            financial_total: 0,
            user_type: null,
            url_pdf: null,
            file: null,
            group_product: null,
            product_integration: []
        }
    },
    methods:{
        getDataApi(){

            this.$vs.loading({
                container: '#home_dashboard',
                scale: 0.6
            })

            this.getApiClients()
 
        },

        getApiClients(){
            this.message_external_import = 'Importando clientes'
            axios.get('/api/clients-api-external').then((resp)=>{
                this.getApiProducts()
            })
        },

        getApiProducts(){
            this.message_external_import = 'Importando produtos'
            axios.get('/api/products-api-external').then((resp)=>{
                this.getApiTablePrice()
            })
        },

        getApiTablePrice(){
            this.message_external_import = 'Importando tabela de preços'
            axios.get('/api/table-price-api-external').then((resp)=>{
                this.message_external_import = null;
                this.getApiPaymentMethod()
            })
        },

        getApiPaymentMethod(){
            this.message_external_import = 'Importando metodos de pagamento'
            axios.get('/api/payment-method-api-external').then((resp)=>{
                this.getApiPaymentTerms()
            })
        },

        getApiPaymentTerms(){
            this.message_external_import = 'Importando tipos de pagamento'
            axios.get('/api/payment-terms-api-external').then((resp)=>{
                this.getApiCarriers()
            })
        },

        getApiCarriers(){
            this.message_external_import = 'Importando transportadoras'
            axios.get('/api/carriers-api-external').then((resp)=>{
                this.message_external_import = null
                this.$vs.loading.close("#home_dashboard > .con-vs-loading")
            })
        },

        

        getTotal(){
            axios.get('/api/total-sales').then((resp)=>{
                this.financial_total = resp.data.financial_total
                this.total_sales = resp.data.total_sales
            })
        },

        onFileChange(e) {
            this.file = e.target.files[0]
            this.url_pdf = URL.createObjectURL(this.file)
            this.active_send = true
        },

        chooseFiles(){
            document.getElementById("fileUploadCatalogo").click()
        },

        sendCatalog(){

            let formData = new FormData()

            formData.append('file', this.file)

            axios.post('/api/update-catalog/1', formData).then((data)=>{
                this.active_send = false
            })

        },

        getCatalog(){
            axios.get('/api/catalog').then((resp)=>{
                this.url_pdf = resp.data.url
            })
        },

        getIntegrationProduct(){
            axios.get('/api/integration_product').then((resp)=>{
                this.product_integration = resp.data
            })
        },

        delelteIntegration(id){
            axios.delete('/api/integration_product/'+id).then((data)=>{
                this.getIntegrationProduct()
            })
        },

        recordIntegration(){
            if(this.group_product){
                axios.post('/api/integration_product', {code_integration:this.group_product}).then((data)=>{
                    this.group_product = null
                    this.getIntegrationProduct()
                })
            }
        },
        
    },

    created(){
        this.getIntegrationProduct()
        this.getTotal()
        this.getCatalog()
        if (localStorage.user) {
            let user = JSON.parse(localStorage.user);
            
            if(user.enterprise){
                this.user_type = user.enterprise.enterprise_type_id
            }else{
                // user_type = 0, é para o usuario final, aquele usuario que não está ligado a nenhuma empresa.   
                this.user_type = 0
            }
        }
    }

}
</script>

<style scoped>

    .product_integration{
        margin-top: 35px;
    }
    .product_integration p{
        margin: 0;
        border: 1px solid #efeeee;
        margin-bottom: 5px;
        padding: 5px 12px 5px 5px;
    }

    .product_integration p span{
        color: red;
        float: right;
        cursor: pointer;
    }
</style>
