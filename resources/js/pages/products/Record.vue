<template>
    <div>
        <h1>Cadastrar novo produto</h1>
        <form>
            <div v-if="!image">
                <vs-row>
                    <vs-col vs-w="3">
                        <vs-input
                            label="Nome"
                            class="mb-3 mt-2"
                            placeholder="Nome do produto"
                            v-model="form.name"
                            :danger="form.name_validation"
                            danger-text="Esse campo é obrigatório"
                        />
                    </vs-col>
                    <vs-col vs-w="3">
                        <vs-input
                            v-if="money_active"
                            label="Preço"
                            class="mb-3 mt-2"
                            placeholder="Preço do produto"
                            v-model.lazy="form.price"
                            v-money="money"
                            :danger="form.price_validation"
                            danger-text="Esse campo é obrigatório"
                            masked
                        />
                    </vs-col>
                    <vs-col vs-w="3" v-if="edit">
                        <vs-select
                            class="selectExample"
                            label="Status"
                            v-model="form.status"
                        >
                            <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="item,index in optionsStatus" />
                        </vs-select>
                    </vs-col>
                </vs-row>

                <vs-textarea
                    label="Descrição"
                    v-model="form.description"
                />
            </div>
            
            <div class="centerx" v-if="edit">
       
                <vs-upload text="Upload Fotos" fileName="image" automatic :action="'/api/upload/'+form.id" @on-success="successUpload" />
                
                <div class="images">
                    <div class="image" v-for="(img, i) in form.images" :key="i">
                        <span @click="deleteImg(img.id)"><UilTimes size="16px" class="icon_delete" /></span>
                        <img :src="'/uploads/'+img.name" alt="">
                    </div>
                </div>
                
                <vs-button type="relief" @click="record">
                    <span>Editar</span>
                </vs-button>
            </div>
            <div class="centerx" v-if="!edit">
                
                <vs-upload @on-delete="deleteImage" text="Upload Fotos" v-if="image" fileName="image" automatic :action="'/api/upload/'+form.id" @on-success="successUpload" />
                
                <vs-button type="relief" v-if="!image" @click="record">
                    <span>Continuar</span>
                </vs-button>
                
                <vs-button @click="finish" type="relief" v-if="image">
                    <span>Finalizar</span>
                </vs-button>

            </div>
            

        </form>
    </div>
</template>

<script>
import {VMoney} from 'v-money'
import { UploadMedia, UpdateMedia } from 'vue-media-upload';
import { UilTimes } from '@iconscout/vue-unicons'

export default {
    name: "Record",
    components:{
        UploadMedia, UpdateMedia, UilTimes
    },
    data(){
        return{
            edit: false,
            money_active: false,
            image: false,
            form:{
                id: null,
                name: null,
                status: 2,
                price: "",
                name_validation: false,
                price_validation: false,
                description: null,
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
            }
        }
    },
    directives: {money: VMoney},
    methods:{

        successUpload(){
            // this.$vs.notify({color:'success',title:'Upload Success',text:'Lorem ipsum dolor sit amet, consectetur'})
        },

        deleteImg(id){
            axios.post('http://bermar.pgv/api/delete-image-product/'+id).then((item)=>{
                this.form.images = this.$c(this.form.images).filter((item)=>{
                    return id !== item.id
                })
            })
        },

        finish(){
            axios.put('http://bermar.pgv/api/products/'+this.form.id, {status: 1}).then((item)=>{
                this.$vs.notify({
                    color:'success',
                    title:'Produto cadastrado!',
                    text:''
                })
                this.$router.push({ name: 'products' })
            })
        },

        validate(){

            let validate = true

            if (!this.form.name){
                validate = false
                this.form.name_validation = !this.form.name
            }else{
                this.form.name_validation = false
            }

            if (this.form.price == '0,00'){
                validate = false
                this.form.price_validation = true
            }else{
                this.form.price_validation = false
            }

            return validate;

        },
        deleteImage(image){
            axios.post('http://bermar.pgv/api/delete-image-product', {image: image.name, product: this.form.id}).then((item)=>{
            })
        },
        record(){
            this.form.price = this.form.price.replace(".", "")
            this.form.price = parseFloat(this.form.price.toString().replace(",", "."))

            if (this.validate()){

                if (this.edit){
                    axios.put('http://bermar.pgv/api/products/'+this.form.id, this.form).then((item)=>{
                        this.$vs.notify({
                            color:'success',
                            title:'Produto atualizado!',
                            text:''
                        })
                        this.$router.push({ name: 'products' })
                    })
                }else{
                    axios.post('http://bermar.pgv/api/products', this.form).then((item)=>{
                        this.form = item.data
                        this.image = true
                    })
                }
            }
        },

        getProduct(){
            axios.get('http://bermar.pgv/api/products/'+this.$route.params.id).then((data)=>{

                this.form.name = data.data.name
                this.form.description = data.data.description
                this.form.price = data.data.price
                this.form.id = data.data.id
                this.form.status = data.data.status
                this.form.images = data.data.image 
                this.money_active = true
            })
        }
    },

    created() {
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
