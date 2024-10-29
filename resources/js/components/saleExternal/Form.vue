<template>
    <div style="padding: 13px 20px;" id="form-sale-external">
        
        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label">Data da venda</p>
                <vs-input
                    placeholder="Data da venda"
                    v-model="form.date_sale"
                    :danger="form.date_sale_validate"
                    danger-text="Esse campo é obrigatório"
                    v-mask="'##/##/####'"
                />
            </div>
        </vs-col>

        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label">Valor da NF</p>
                <vs-input
                    v-model="form.value"
                    :danger="form.prince_validate"
                    danger-text="Esse campo é obrigatório"
                    v-money="money"
                />
            </div>
        </vs-col>

        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label">Nota Fiscal + Série</p>
                <vs-input
                    placeholder="Número da Nota Fiscal + Série"
                    v-model="form.nfe_number"
                    :danger="form.nfe_validate"
                    danger-text="Esse campo é obrigatório"
                />
            </div>
        </vs-col>

        <vs-col vs-w="6" >
            <div class="form_item width_90">
                <p class="text-label">Série do produto</p>
                <vs-input
                    placeholder="Série do produto"
                    v-model="form.product_serial"
                    :danger="form.serial_validate"
                    danger-text="Esse campo é obrigatório"
                />
            </div>
        </vs-col>

        <vs-col vs-w="12" >
            <div class="form_item width_90">
                <p class="text-label">Produto</p>
                <vs-input
                    class="mb-3 mt-2"
                    placeholder="Buscar produto"
                    v-model="form.product_search"
                    :danger="form.product_search_validate"
                    @input="searcProducts"
                    danger-text="Esse campo é obrigatório"
                />

                
                <div v-if="product_list.length > 0 && list_products_search" class="list_companie_suggest">
                    <p 
                        v-for="(p, i) in product_list" 
                        :key="i" 
                        @click="[form.product_id = p.id, list_products_search = false, form.product_search = p.name]"
                    >
                        {{ p.name }}
                    </p>
                </div>
             
            </div>
        </vs-col>

        <vs-col vs-w="6" >
            <div class="form_item width_90 mt-2">
                <p class="text-label">Nota fiscal</p>

                <span v-if="url_pdf_validate"><div class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to" style="height: 22px;"><span class="span-text-validation">O upload da nota fiscal é obrigatório</span></div></span>
                 
                <div v-if="!url_pdf" class="upload_notafiscal" @click="chooseFiles">
                    Clique para fazer upload
                </div>

                <div class="view_pdf" v-if="url_pdf">
                    <p @click="url_pdf = null">X</p>
                    <iframe class="mt-3" :src="url_pdf" height="200" width="200" />
                </div>

                <input id="fileUploadNfe" name="nfe" type="file" accept=".pdf" v-on:change="onFileChange" hidden>
            </div>
        </vs-col>


        <vs-col vs-w="12" >
            <Button 
                id_loadding="cadastro_venda" 
                name_button="Cadastrar venda" 
                @send="record"
                class="mt-3"
                style="text-align: right;"
            />
        </vs-col>

    </div>
</template>

<script>

import Button from '../../components/ButtonLoadding'
import {mask} from 'vue-the-mask'
import {VMoney} from 'v-money'

export default {

    components: { Button },
    directives: {mask, money: VMoney},

    name: "SaleComponent",

    data(){
        return{

            form:{
                date_sale: null,
                date_sale_validate: false,

                value: 0,
                prince_validate: false,

                nfe_number: null,
                nfe_validate: false,

                product_serial: null,
                serial_validate: false,

                product_search: null,
                product_search_validate: false,

                product_id: null
            },

            money: {
                decimal: ',',
                thousands: '.',
                precision: 2,
                masked: false /* doesn't work with directive */
            },

            product_list: [],
            url_pdf: null,
            url_pdf_validate: false,
            first_search: true,
            count_search: 0

        }
    },

    created() {
    },

    methods:{

        onFileChange(e) {
            this.file = e.target.files[0]
            this.url_pdf = URL.createObjectURL(this.file)
            this.active_send = true
        },

        chooseFiles(){
            document.getElementById("fileUploadNfe").click()
        },

        searcProducts(){

            // se tem modificações na busca, reseta o product_id, caso já foi selecionado anteriormente.
            this.form.product_id = null

            // ativa a lista no html
            this.list_products_search = true

            // 0 CARACTERES PARA BUSCAR
            if(this.form.product_search.length == 0){
                this.count_search = 0
                return true
            }

            // Não é a primeira busca e tem 3 ou menos caracteres, gera outra busca
            if(!this.first_search && this.form.product_search.length <= 3){
                this.getProductSearch(this.form.product_search)
                return true
            }

            // Tem menos de 3 caracteres pra buscar
            if(this.form.product_search.length < 3){
                this.count_search = 0
                return false
            }

            // é a primeira busca
            if(this.first_search){
                this.count_search = this.form.product_search.length 
                this.getProductSearch(this.form.product_search)
                this.first_search = false
                return true
            }

            
            if(this.form.product_search.length > 5 && (this.form.product_search.length > (this.count_search + 3) || this.form.product_search.length < (this.count_search - 3))){
                this.count_search = this.form.product_search.length 
                this.getProductSearch(this.form.product_search)
                return true
            }
        },

        getProductSearch(name){
            //loading
            this.$vs.loading({
                container: '#form-sale-external',
                scale: 0.6
            })

            axios.get('/api/search-product-name/'+name).then((resp)=>{
                this.product_list = resp.data
                this.$vs.loading.close("#form-sale-external > .con-vs-loading");
            })
        },

        record(){

            if(!this.validation()){
                return false
            }

            //loading
            this.$vs.loading({
                container: '#form-sale-external',
                scale: 0.6
            })

            let formData = new FormData()

            formData.append('file', this.file)
            formData.append('date_sale', this.form.date_sale)
            formData.append('product_id', this.form.product_id)
            formData.append('value', this.form.value)
            formData.append('nfe_number', this.form.nfe_number)
            formData.append('product_serial', this.form.product_serial)

            axios.post('/api/external-sale', formData).then((item)=>{

                this.$vs.notify({
                    color:'success',
                    title:'Venda cadastrada!',
                    text:''
                })

                this.$emit('newSale', item.data[0]);


            }).catch((error) => {
                // Ações em caso de erro
                this.$vs.notify({
                    color: 'danger',
                    title: 'Erro ao cadastrar venda!',
                    text: 'Ocorreu um erro, tente novamente.'
                });
            }).finally(() => {
                // Sempre fechar o loading, seja no sucesso ou no erro
                setTimeout(() => {
                    this.$vs.loading.close("#form-sale-external > .con-vs-loading");
                }, 1);
            });
            
        },

        validation(){

            let validate = true

            // DATA DA VENDA
            if(!this.form.date_sale){
                this.form.date_sale_validate = true
                validate = false
            }else{
                this.form.date_sale_validate = false
            }

            // PREÇO
            if(this.form.value == '0,00'){
                this.form.prince_validate = true
                validate = false
            }else{
                this.form.prince_validate = false
            }

            // NFE
            if(!this.form.nfe_number){
                this.form.nfe_validate = true
                validate = false
            }else{
                this.form.nfe_validate = false
            }

            // NFE
            if(!this.form.product_serial){
                this.form.serial_validate = true
                validate = false
            }else{
                this.form.serial_validate = false
            }

            // NFE
            if(!this.form.product_id){
                this.form.product_search_validate = true
                validate = false
            }else{
                this.form.product_search_validate = false
            }

            // UPLOAD NFE
            if (!this.url_pdf) {
                this.url_pdf_validate = true
            } else {
                this.url_pdf_validate = false
            }

            return validate
        }
    }
}

</script>

<style>
.duplicate p{
    margin-bottom: 0;
    margin-top: 5px;
}
.selected p{
    float: left;
    margin-right: 6px;
    background: #555;
    color: #fff !important;
    padding: 8px 13px;
    border-radius: 3px;
}
.selected p span{
    cursor: pointer;
    margin-left: 15px;
    font-size: 15px;
}


.error{
    color:red;
}
.required{
    color:red;
}
.width_90{
    width: 90% !important;
}
.list_companie_suggest{
    background: #fff;
    position: relative;
    z-index: 999999 !important;
    height: 318px;
    overflow: auto;
}
.list_companie_suggest p{
    margin: 0;
    border: 1px solid #efeeee;
    padding: 14px;
    background: #fff;
    color: #000 !important;
    cursor: pointer;
}
.list_companie_suggest p:hover{
    background: #efeeee;
}

.text-label {
    margin-bottom: 3px;
    font-weight: 600 !important;
    color: #000 !important;
    font-size: 15px !important;
}

.upload_notafiscal{
    background: #efeeee;
    color: #333;
    text-align: center;
    padding: 30px;
    cursor: pointer;
}
.view_pdf p{
    color: red !important;
    margin: 0;
    cursor: pointer;
}
</style>