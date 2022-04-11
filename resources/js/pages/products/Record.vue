<template>
    <div>
        <h1>Cadastrar novo produto</h1>
        <form>
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
                <vs-col vs-w="3">
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

            <vs-button type="relief" @click="record">
                <span v-if="edit">Editar</span>
                <span v-if="!edit">Cadastrar</span>
            </vs-button>

        </form>
    </div>
</template>

<script>
import {VMoney} from 'v-money'

export default {
    name: "Record",
    data(){
        return{
            edit: false,
            money_active: false,
            form:{
                id: null,
                name: null,
                status: 1,
                price: "",
                name_validation: false,
                price_validation: false,
                description: null,
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
                        this.$vs.notify({
                            color:'success',
                            title:'Produto cadastrado!',
                            text:''
                        })
                        this.$router.push({ name: 'products' })
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

</style>
