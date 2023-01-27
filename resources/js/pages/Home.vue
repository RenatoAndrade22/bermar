<template>
    <div>
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
                <b-col>
                    <div class="card_column">
                        <h1>Catalogo</h1>

                        <p v-if="!url_pdf && !form.url_catalog" style="cursor:pointer;" @click="chooseFiles">Carregar catalogo</p>
                        <p v-if="!url_pdf && form.url_catalog" style="cursor:pointer;" @click="chooseFiles">Atualizar catalogo</p>
                       
                        <input id="fileUploadCatalogo" type="file" accept=".pdf" v-on:change="onFileChange" hidden>
                        <iframe v-if="url_pdf" :src="url_pdf" height="200" width="200" />

                        <p style="cursor: pointer;font-size: 15px !important;font-weight: bold !important;margin-top: 10px;" @click="sendCatalog" v-if="url_pdf">Enviar</p>

                    </div>
                </b-col>
                
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
            total_sales: 0,
            financial_total: 0,
            user_type: null,
            url_pdf: null,
            file: null
        }
    },
    methods:{

        getTotal(){
            axios.get('/api/total-sales').then((resp)=>{
                this.financial_total = resp.data.financial_total
                this.total_sales = resp.data.total_sales
            })
        },

        onFileChange(e) {
            this.file = e.target.files[0]
            this.url_pdf = URL.createObjectURL(this.file)
        },

        chooseFiles(){
            document.getElementById("fileUploadCatalogo").click()
        },

        sendCatalog(){

            let formData = new FormData();

            formData.append('file', this.file);
            axios.post('/api/upload-file-chat/'+this.chat[0].id, formData).then((data)=>{
                this.url_image = null
            })
        }

    },

    created(){
        this.getTotal()
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

<style>

</style>
