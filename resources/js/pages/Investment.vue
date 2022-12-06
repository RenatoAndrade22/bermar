<template>
    <div>
        <div class="card_column mb-3">
            <b-row class="metricas">
                <b-col>
                    <p style="text-align: left;">Ação</p>
                    <h1>{{ content.name }}</h1>
                </b-col>
                <b-col>
                    <p><span>{{ content.amount }}</span>Quantidade</p>
                </b-col>
                <b-col>
                    <p><span>{{ content.buy }}</span>Compradas</p>
                </b-col>
                <b-col>
                    <p><span>{{ content.sale }}</span>Vendidas</p>
                </b-col>
            </b-row>
        </div>

        <b-row>
            <b-col>
                <div class="card_column">
                    <h1>R$ 2.000,00</h1>
                    <p>Rendimento mensal</p>
                    <chart height="150"></chart>
                </div>
            </b-col>
            <b-col>
                <div class="card_column">
                    <h1>R$ 2.000,00</h1>
                    <p>Rendimento semestral</p>
                    <chart height="150"></chart>
                </div>
            </b-col>

        </b-row>
    </div>
</template>

<script>
import Chart from '../components/Chart'

export default {
    name: "Investment",
    props:{
        content:{}
    },
    components:{
        Chart
    }
}

</script>

<style scoped>
    .metricas p span{
        width: 100%;
        float: left;
        text-align: center;
        font-weight: 600;
        font-size: 18px;
    }
    .metricas p{
        width: 100%;
        float: left;
        text-align: center;
        margin: 0;
    }
</style>
