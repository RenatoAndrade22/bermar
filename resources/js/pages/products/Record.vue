<template>
    <div id="product-record">
        <h1 class="m-4">Cadastrar novo produto</h1>
        <vs-row vs-w="12" style="width: 100% !important; display: block;">

            <template v-if="!image">

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">* Nome</p>
                        <vs-input
                            :danger="form.name_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Nome"
                            v-model="form.name"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Preço</p>
                        <vs-input
                            v-if="money_active"
                            placeholder="Preço"
                            v-model="form.price"
                            v-money="money"
                            masked
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
                        <p class="text-label">Aparecer no site</p>
                        <vs-select
                            v-model="form.site_appear"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in site_appear" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">* Família</p>
                        <vs-select
                            v-model="form.category_id"
                            :danger="form.category_validation"
                            danger-text="Campo obrigatório"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in categories" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Tensão do motor</p>
                        <vs-select
                            v-model="form.voltage"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in voltage" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Potencia do motor</p>
                        <vs-select
                            v-model="form.power"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in power" />
                        </vs-select>
                    </div>
                </vs-col>

               

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <hr class="divisor" />
                </vs-col>

                <h2 class="subtitle">Dimensões do produto</h2>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Largura</p>
                        <vs-input
                            v-if="money_active"
                            :danger="form.width_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Largura"
                            v-model="form.width"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Peso</p>
                        <vs-input
                            v-if="money_active"
                            :danger="form.weight_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Peso"
                            v-model="form.weight"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Comprimento</p>
                        <vs-input
                            v-if="money_active"
                            :danger="form.length_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Comprimento"
                            v-model="form.length"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Altura</p>
                        <vs-input
                            v-if="money_active"
                            :danger="form.height_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Altura"
                            v-model="form.height"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                


                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <hr class="divisor" />
                </vs-col>

                <h2 class="subtitle">Dimensões da embalagem</h2>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Largura</p>
                        <vs-input
                            v-if="money_active"
                            placeholder="Largura"
                            v-model="form.packing_width"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Peso</p>
                        <vs-input
                            v-if="money_active"
                            placeholder="Peso"
                            v-model="form.packing_weight"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Comprimento</p>
                        <vs-input
                            v-if="money_active"
                            placeholder="Comprimento"
                            v-model="form.packing_length"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Altura</p>
                        <vs-input
                            v-if="money_active"
                            placeholder="Altura"
                            v-model="form.packing_height"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Cubagem</p>
                        <vs-input
                            v-if="money_active"
                            placeholder="Cubagem"
                            v-model="form.cubagem"
                            v-money="money"
                            masked
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <hr class="divisor" />
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Vídeo</p>
                        <vs-input
                            :danger="form.video_validation"
                            danger-text="Campo obrigatório"
                            placeholder="Vídeo"
                            v-model="form.video"
                        />
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
                    <hr class="divisor" />
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
                    <div class="editor">
                        <p class="text-label">* Descrição</p>
                        <vue-editor v-model="form.description"></vue-editor>
                        <div v-if="form.description_validation" class="con-text-validation span-text-validation-danger vs-input--text-validation-span v-enter-to" style="height: 22px;"><span class="span-text-validation"> Campo obrigatório </span></div>
                    </div>
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
                    <div class="editor mt-3">
                        <p class="text-label">Ficha técnica</p>
                        <vue-editor v-model="form.datasheet"></vue-editor>
                    </div>
                </vs-col>

            </template>

            <template v-if="image">
                <h3>Imagens</h3>
                <div class="centerx">
                    <vs-upload automatic fileName="image" text="Clique aqui" :action="'/api/upload/'+form.id" @on-delete="deleteImage" />
                </div>
                
                <div class="manual">
                    <hr />
                    <h3>Upload do Manual</h3>
                    <div class="centerx">
                        <div class="con-input-upload"><input id="fileUploadCatalogo" type="file" accept=".pdf" v-on:change="addManual" ><span class="text-input"> Clique aqui </span><span class="input-progress" style="width: 0%;"></span><button disabled="disabled" type="button" title="Upload" class="btn-upload-all vs-upload--button-upload"><i translate="no" class="material-icons notranslate"> cloud_upload </i></button></div>
                        <iframe v-if="url_manual" :src="url_manual" height="200" width="200" />
                        <iframe v-if="form.manual && !url_manual" :src="form.manual" height="200" width="200" />
                    </div>
                </div>

                <div class="manual">
                    <hr />
                    <h3>Upload do Certificado</h3>
                    <div class="centerx">
                        <div class="con-input-upload">
                            <input id="fileUploadCatalogo" type="file" accept=".pdf" v-on:change="addCertificate" />
                            <span class="text-input"> Clique aqui </span>
                            <span class="input-progress" style="width: 0%;"></span>
                            <button disabled="disabled" type="button" title="Upload" class="btn-upload-all vs-upload--button-upload">
                                <i translate="no" class="material-icons notranslate"> cloud_upload </i>
                            </button>
                        </div>
                        <iframe v-if="url_certificate" :src="url_certificate" height="200" width="200" />
                        <iframe v-if="form.certificate && !url_certificate" :src="form.certificate" height="200" width="200" />
                    </div>
                </div>

            </template>

            <template v-if="edit">
                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
                    <hr class="divisor" />
                </vs-col>
                <h4>Imagens</h4>

                <vs-row vs-w="12" style="width: 100% !important; display: block;">
                    <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="3" v-for="(img, i) in form.images" :key="i">
                        <div class="single_image">
                            <span @click="deleteImageById(img.id)">X</span>
                            <img :src="img.url" alt="">
                        </div>
                    </vs-col>
                </vs-row>

                <div class="centerx">
                    <vs-upload automatic fileName="image" text="Clique aqui" :action="'/api/upload/'+form.id" @on-delete="deleteImage" />
                </div>

                <div class="manual">
                    <hr />
                    <h3>Upload do Manual</h3>
                    <div class="centerx">
                        <div class="con-input-upload"><input id="fileUploadCatalogo" type="file" accept=".pdf" v-on:change="addManual" ><span class="text-input"> Clique aqui </span><span class="input-progress" style="width: 0%;"></span><button disabled="disabled" type="button" title="Upload" class="btn-upload-all vs-upload--button-upload"><i translate="no" class="material-icons notranslate"> cloud_upload </i></button></div>
                        <iframe v-if="url_manual" :src="url_manual" height="200" width="200" />
                        <iframe v-if="form.manual && !url_manual" :src="form.manual" height="200" width="200" />
                    </div>
                </div>

                <div class="manual">
                    <hr />
                    <h3>Upload do Certificado</h3>
                    <div class="centerx">
                        <div class="con-input-upload">
                            <input id="fileUploadCatalogo" type="file" accept=".pdf" v-on:change="addCertificate" />
                            <span class="text-input"> Clique aqui </span>
                            <span class="input-progress" style="width: 0%;"></span>
                            <button disabled="disabled" type="button" title="Upload" class="btn-upload-all vs-upload--button-upload">
                                <i translate="no" class="material-icons notranslate"> cloud_upload </i>
                            </button>
                        </div>
                        <iframe v-if="url_certificate" :src="url_certificate" height="200" width="200" />
                        <iframe v-if="form.certificate && !url_certificate" :src="form.certificate" height="200" width="200" />
                    </div>
                </div>
                
            </template>

            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
                <vs-button type="relief" class="mt-3" @click="recordProduct" v-if="!image && !edit">Próxima etapa</vs-button>
                <vs-button type="relief" class="mt-3" @click="recordProduct" v-if="edit">Atualizar</vs-button>
                <vs-button type="relief" class="mt-3" @click="finish" v-if="image">Finalizar</vs-button>
            </vs-col>


        </vs-row>

    </div>
</template>

<script>
import {VMoney} from 'v-money'
import { UploadMedia, UpdateMedia } from 'vue-media-upload';
import { UilTimes } from '@iconscout/vue-unicons'
import { VueEditor } from "vue2-editor";

export default {
    name: "Record",
    components:{
        UploadMedia, UpdateMedia, UilTimes, VueEditor
    },
    data(){
        return{
            edit: false,
            money_active: false,
            image: false,
            categories: [],
            site_appear: [
                {
                    id: 1,
                    name: 'Aparecer'
                },
                {
                    id: 0,
                    name: 'Não aparecer'
                },
            ],
            status:[
                {
                    id: 2,
                    name: 'Inativo - Produto externo'
                },
                {
                    id: 1,
                    name: 'Ativo'
                },
                {
                    id: 0,
                    name: 'Inativo'
                },
            ],

            voltage:[
                {
                    id: '110',
                    name: '110 volts'
                },
                {
                    id: '220',
                    name: '220 volts'
                },
            ],

            power:[
                {
                    id: '1000',
                    name: '1.000'
                },
                {
                    id: '2000',
                    name: '2.000'
                },
                {
                    id: '3000',
                    name: '3.000'
                },
            ],

            form:{
                id: null,

                name: null,
                name_validation: false,
                manual: null,
                power: '1000',
                voltage: '110',
                packing_width: null,
                packing_weight: null,
                packing_length: null,
                packing_height: null,
                cubagem: null,
                certificate: null,

                status: 1,
                category_id: null,
                category_validation: false,

                price: "",
                price_validation: false,

                description: null,
                description_validation: false,

                datasheet: null,
                datasheet_validation: false,

                width: null,
                width_validation: false,

                weight: null,
                weight_validation: false,

                length: null,
                length_validation: false,

                height: null,
                height_validation: false,


                video: null,
                video_validation: false,

                site_appear: 0,
                
                images: []
            },

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
            money: {
                decimal: ',',
                thousands: '.',
                precision: 2,
                masked: false /* doesn't work with directive */
            },
            url_manual: null,
            url_certificate: null,
        }
    },
    directives: {money: VMoney},
    methods:{

        addCertificate(e){
            let file = e.target.files[0]
            this.url_certificate = URL.createObjectURL(file)
            let formData = new FormData()

            formData.append('file', file)

            //loading
            this.$vs.loading({
                container: '#product-record',
                scale: 0.6
            })

            axios.post('/api/upload-certificate/'+this.form.id, formData).then((data)=>{
                setTimeout(() => {
                    this.$vs.loading.close("#product-record > .con-vs-loading");
                }, 1)
            })
        },

        addManual(e){
            
            let file = e.target.files[0]
            this.url_manual = URL.createObjectURL(file)
            let formData = new FormData()

            formData.append('file', file)

            //loading
            this.$vs.loading({
                container: '#product-record',
                scale: 0.6
            })

            axios.post('/api/upload-manual/'+this.form.id, formData).then((data)=>{
                setTimeout(() => {
                    this.$vs.loading.close("#product-record > .con-vs-loading");
                }, 1)
            })
        },

        successUpload(){
            this.$vs.notify({color:'success',title:'Upload Success',text:'Lorem ipsum dolor sit amet, consectetur'})
        },

        deleteImg(id){
            axios.post('/api/delete-image-product/'+id).then((item)=>{
                this.form.images = this.$c(this.form.images).filter((item)=>{
                    return id !== item.id
                })
            })
        },

        finish(){
            axios.put('/api/product/'+this.form.id, {status: 1, video: this.form.video}).then((item)=>{
                this.$vs.notify({
                    color:'success',
                    title:'Produto cadastrado!',
                    text:''
                })
                this.$router.push({ name: 'products' })
            })
        },

        validate(){

            this.form.price = this.form.price.replace(".", "")
            this.form.price = parseFloat(this.form.price.toString().replace(",", "."))

            this.form.width = this.form.width.replace(".", "")
            this.form.width = parseFloat(this.form.width.toString().replace(",", "."))

            this.form.weight = this.form.weight.replace(".", "")
            this.form.weight = parseFloat(this.form.weight.toString().replace(",", "."))

            this.form.length = this.form.length.replace(".", "")
            this.form.length = parseFloat(this.form.length.toString().replace(",", "."))

            this.form.height = this.form.height.replace(".", "")
            this.form.height = parseFloat(this.form.height.toString().replace(",", "."))


            this.form.packing_width = this.form.packing_width.replace(".", "")
            this.form.packing_width = parseFloat(this.form.packing_width.toString().replace(",", "."))

            this.form.packing_weight = this.form.packing_weight.replace(".", "")
            this.form.packing_weight = parseFloat(this.form.packing_weight.toString().replace(",", "."))

            this.form.packing_length = this.form.packing_length.replace(".", "")
            this.form.packing_length = parseFloat(this.form.packing_length.toString().replace(",", "."))

            this.form.packing_height = this.form.packing_height.replace(".", "")
            this.form.packing_height = parseFloat(this.form.packing_height.toString().replace(",", "."))

            this.form.cubagem = this.form.cubagem.replace(".", "")
            this.form.cubagem = parseFloat(this.form.cubagem.toString().replace(",", "."))

            let i = true

            this.form.name_validation = !this.form.name ? true : false
            if(!this.form.name)
                i = false

            // this.form.width_validation = !this.form.width ? true : false
            // if(!this.form.width)
            //     i = false

            // this.form.weight_validation = !this.form.weight ? true : false
            // if(!this.form.weight)
            //     i = false

            // this.form.length_validation = !this.form.length ? true : false
            // if(!this.form.length)
            //     i = false

            // this.form.height_validation = !this.form.height ? true : false
            // if(!this.form.height)
            //     i = false

            this.form.category_validation = !this.form.category_id ? true : false
            if(!this.form.category_id)
                i = false


            this.form.description_validation = !this.form.description ? true : false

            if(!this.form.description)
                i = false

            // this.form.width_validation = !this.form.width ? true : false
            // if(!this.form.width)
            //     i = false

            // this.form.weight_validation = !this.form.weight ? true : false
            // if(!this.form.weight)
            //     i = false

            // this.form.length_validation = !this.form.length ? true : false
            // if(!this.form.length)
            //     i = false

            // this.form.height_validation = !this.form.height ? true : false
            // if(!this.form.height)
            //     i = false


            return i
        },

        deleteImage(image){
            axios.post('/api/delete-image-product', {image: image.name, product: this.form.id}).then((item)=>{})
        },

        deleteImageById(id){
            axios.delete('/api/product-image/'+id).then((item)=>{
                this.form.images = this.$c(this.form.images).filter((item) => {
                    return item.id != id
                })
            })
        },

        recordProduct(){

            if (this.validate()){

                if (this.edit){
                    axios.put('/api/product/'+this.form.id, this.form).then((item)=>{
                        this.$vs.notify({
                            color:'success',
                            title:'Produto atualizado!',
                            text:''
                        })
                        this.$router.push({ name: 'products' })
                    })
                }else{
                    axios.post('/api/product', this.form).then((item)=>{
                        this.form = item.data
                        this.image = true
                    })
                }
            }
        },

        getProduct(){
            
            setTimeout(() => {
                    this.$vs.loading({
                    container: '#product-record',
                    scale: 0.6
                })
            }, 1)
            
            axios.get('/api/product/'+this.$route.params.id).then((data)=>{

                this.form.id = data.data.id
                this.form.name = data.data.name
                this.form.manual = data.data.manual

                this.form.status = data.data.status
                this.form.category_id = data.data.category_id
                this.form.price = data.data.price
                this.form.description = data.data.description
                this.form.datasheet = data.data.datasheet
                this.form.width = data.data.width
                this.form.weight = data.data.weight
                this.form.length = data.data.length
                this.form.height = data.data.height
                this.form.video = data.data.video
                this.form.images = data.data.product_images
                this.form.site_appear = data.data.site_appear

                if(data.data.certificate){
                    this.form.certificate = data.data.certificate.url
                }

                this.form.power = data.data.power
                this.form.voltage = data.data.voltage

                this.form.packing_width  = data.data.packing_width
                this.form.packing_weight = data.data.packing_weight
                this.form.packing_length = data.data.packing_length
                this.form.packing_height = data.data.packing_height
                this.form.cubagem  = data.data.cubagem

                this.money_active = true

                setTimeout(() => {
                    this.$vs.loading.close("#product-record > .con-vs-loading");
                }, 1)

            })
        },

        getCategories(){
            axios.get('/api/sub-categories').then((resp)=>{
                this.categories = resp.data
            })
        }
    },

    created() {
        this.getCategories()
        if (this.$route.params.id !== undefined) {
            this.edit = true
            this.getProduct()
        }else{
            this.money_active = true
        }
    }
}
</script>

<style scoped>

    .manual{
        width: 100%;
        float: left ;
    }
    .subtitle{
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        margin: 20px;
        float: left;
        width: 100%;
    }
    .centerx{
        width: 100%;
        float: left;
    }
    .single_image{
        position: relative;
        padding: 2px;
        width: 100%;
    }
    .single_image img{
        width: 100%;
    }
    .single_image span{
        position: absolute;
        right: 0;
        background: #ffffff;
        font-size: 12px;
        padding: 5px 7px;
        color: red;
        cursor: pointer;
    }

    .single_image span:hover{
        background: red;
        color: #ffffff;
    }
    .editor{
        width: 95%;
    }
    .divisor{
        height: 1px;
        background: black;
        width: 94%;
    }
    .images{
        width: 100%;
        float: left;
        margin-bottom: 15px;
    }
    .image{
        float: left;
        position: relative;
        width: 170px;
        margin-right: 10px;
    }
    .image img{
        width: 100%;
    }
    .icon_delete{
        cursor: pointer;
        position: absolute;
        right: 2px;
        top: 2px;
        background: #fff;
        color: red;
        text-align: center;
    }
</style>
