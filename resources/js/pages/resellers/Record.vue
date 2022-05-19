<template>
    <div>
        <h1>Cadastrar novo fornecedor</h1>
        <form>
            <h5>Dados do responsável</h5>
            <vs-row>
                <vs-col vs-w="3">
                    <vs-input
                        label="Nome"
                        class="mb-3 mt-2"
                        placeholder="Nome do fornecedor"
                        v-model="form.name"
                        :danger="form.name_validation"
                        danger-text="Esse campo é obrigatório"
                    />
                </vs-col>
                <vs-col vs-w="3">
                    <vs-input
                        label="Nome"
                        class="mb-3 mt-2"
                        placeholder="CNPJ"
                        v-model="form.name"
                        :danger="form.name_validation"
                        danger-text="Esse campo é obrigatório"
                    />
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
                price: "",
                name_validation: false,
                price_validation: false,
                description: null,
            },
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
    h5{
        border-bottom: 1px solid #efeeee;
        padding-bottom: 12px;
        margin-top: 28px;
        margin-bottom: 12px;
    }
</style>
