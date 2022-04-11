<template>
    <div>
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
import { BRow, BCol } from 'bootstrap-vue'
import Chart from '../components/Chart'

export default {
    components:{
        BRow, BCol, Chart
    },

}
</script>

<style>

</style>
