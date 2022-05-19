<template>
    <div>
        <p class="back" @click="back">
            <UilAngleDoubleLeft color="#ff4757" size="18px" style="margin-top: -2px;" />
            Voltar
        </p>
        <div v-if="product">
            <p><b>Nome:</b> {{ product.name }}</p>
            <p><b>Descrição:</b> {{ product.description }}</p>
            <p><b>Preço:</b> {{ product.price }}</p>
        </div>

    </div>
</template>

<script>

import { UilAngleDoubleLeft } from '@iconscout/vue-unicons'

export default {
    name: "View",
    components: { UilAngleDoubleLeft },
    data(){
        return{
            product: null
        }
    },
    methods:{
        back(){
            this.$router.push({ name: 'products' })
        },
        getProduct(){
            axios.get('http://bermar.pgv/api/products/'+this.$route.params.id).then((data)=>{
                this.product = data.data
            })
        },
    },
    created() {
        this.getProduct()
    }
}
</script>

<style scoped>
    .back{
        cursor: pointer;
    }
</style>
