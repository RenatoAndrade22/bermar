<template>
    <div>
        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    <span style="color:#EE1B21">({{ sales.length }})</span> Vendas
                </vs-navbar-title>
            </div>
        </vs-navbar>

        <vs-row class="mt-4">
            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="3">
                <vs-select
                    class=""
                    label="Status venda"
                    v-model="filters.status_sale"
                >
                    <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="item,index in status_sales" />
                </vs-select>
                <span v-if="filters.status_sale" class="clear_select" @click="filters.status_sale = null">
                    <UilTimes size="19px" color="#666" />
                </span>
            </vs-col>

            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="3">
                <vs-select
                    class=""
                    label="Status pagamento"
                    v-model="filters.status_payment"
                >
                    <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="item,index in status_payment" />
                </vs-select>
                <span v-if="filters.status_payment" class="clear_select" @click="filters.status_payment = null">
                    <UilTimes size="19px" color="#666" />
                </span>
            </vs-col>
            
            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="3">
                <vs-select
                    class=""
                    label="Status entrega"
                    v-model="filters.status_delivery"
                >
                    <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="item,index in status_delivery" />
                </vs-select>
                <span v-if="filters.status_delivery" class="clear_select" @click="filters.status_delivery = null">
                    <UilTimes size="19px" color="#666" />
                </span>
            </vs-col>

            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="3">
                <vs-select
                    class=""
                    label="Nota fiscal"
                    v-model="filters.invoice"
                >
                    <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="item,index in invoice" />
                </vs-select>
                <span v-if="filters.invoice" class="clear_select" @click="filters.invoice = null">
                    <UilTimes size="19px" color="#666" />
                </span>
            </vs-col>
            
        </vs-row>

        <vs-table 
            stripe 
            :data="list_products" 
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
                <vs-th>
                    Status compra
                </vs-th>
                <vs-th>
                    Status pagamento
                </vs-th>
                <vs-th>
                    Status entrega
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

                    <vs-td :data="data[indextr].value">
                        {{data[indextr].value}}
                    </vs-td>

                    <vs-td :data="data[indextr].buyer">
                        {{data[indextr].buyer}}
                    </vs-td>

                    <vs-td :data="data[indextr].status_sale">
                        {{ getText(data[indextr].status_sale, status_sales) }}
                    </vs-td>

                    <vs-td :data="data[indextr].status_payment">
                        {{ getText(data[indextr].status_payment, status_payment) }}
                    </vs-td>

                    <vs-td :data="data[indextr].status_delivery">
                        {{ getText(data[indextr].status_delivery, status_delivery) }}
                    </vs-td>

                    <vs-td :data="data[indextr].invoice">
                        <div v-if="data[indextr].invoice == ''">
                            <div @click="[upload_file = true, sale_order_id = data[indextr].id]">
                                <UilCloudUpload size="19px" color="#e85d04" />
                                <span>Enviar</span>
                            </div>
                        </div>
                        <div v-if="data[indextr].invoice != ''">
                            <UilCloudDownload size="19px" color="#76c893" />
                            <span>Baixar</span>
                        </div>
                    </vs-td>

                </vs-tr>
            </template>
        </vs-table>
        <vs-popup title="Enviar nota fiscal" :active.sync="upload_file">
            <h1>{{sale_order_id}}</h1>
            <vs-upload text="Upload nota fiscal" fileName="file" :action="'/api/upload-invoice/'" />
        </vs-popup>
    </div>
</template>

<script>

import { UilCloudUpload, UilCloudDownload, UilTimes } from '@iconscout/vue-unicons'

export default {
    name: "Sales",
    components:{
        UilCloudUpload, UilCloudDownload, UilTimes
    },
    data(){
        return{
            search: null,
            order_selected: null,
            delete_product: null,
            upload_file: false,
            sale_order_id: null,
            filters:{
                status_sale: null,
                status_payment: null,
                status_delivery: null,
                invoice: null
            },
            sales:[
                {
                    id: 265,
                    value: '1.550,00',
                    buyer: 'Fernando',
                    status_sale: 1,
                    status_payment: 1,
                    status_delivery: 1,
                    invoice: ''
                },
                
                {
                    id: 295,
                    value: '3.550,00',
                    buyer: 'Fernando',
                    status_sale: 1,
                    status_payment: 1,
                    status_delivery: 1,
                    invoice: ''
                },
                
                {
                    id: 665,
                    value: '550,00',
                    buyer: 'Fernando',
                    status_sale: 1,
                    status_payment: 2,
                    status_delivery: 3,
                    invoice: 'link_do_arquivo'
                },
                
                {
                    id: 765,
                    value: '1.550,00',
                    buyer: 'Fernando',
                    status_sale: 2,
                    status_payment: 1,
                    status_delivery: 2,
                    invoice: ''
                },
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
        }
    },
    created() {
    },
    computed:{

        list_products(){
            let sales = this.$c(this.sales)

            if (this.filters.status_sale)
                sales = sales.where('status_sale', this.filters.status_sale)

            if (this.filters.status_payment)
                sales = sales.where('status_payment', this.filters.status_payment)

            if (this.filters.status_delivery)
                sales = sales.where('status_delivery', this.filters.status_delivery)

            console.log('iteeemmm', this.filters.invoice)

            if (this.filters.invoice){
                if(this.filters.invoice == 1)
                    sales = sales.where('invoice', '!==', '')

                
                if(this.filters.invoice == 2)
                    sales = sales.where('invoice', '')
            }
            
            return sales.all()
        }
    }
}
</script>

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
