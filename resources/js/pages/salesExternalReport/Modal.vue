<template>
    <div id="modal_comissions">

        <div class="header_modal">
            <vs-row>
                <vs-col vs-w="6">
                    <p><b>Vendedor:</b> {{ seller.sellet_name }}</p>
                </vs-col>
                <vs-col vs-w="6">
                    <p><b>Revenda:</b> {{ seller.enterprise_resale_name }}</p>
                </vs-col>
                <vs-col vs-w="6">
                    <p><b>Representante:</b> {{ seller.enterprise_repre_name }}</p>
                </vs-col>
                <vs-col vs-w="6">
                    <p><b>Total comissão:</b> {{ valueFormat(seller.total_comissions) }}</p>
                </vs-col>
                <vs-col vs-w="12">
                    <vs-button @click="downloadPDF" type="relief">
                        Baixar PDF
                    </vs-button>
                </vs-col>
            </vs-row>
        </div>

        <vs-table
            stripe
            :data="seller.comissions"
            class="header"
        >
            <template slot="thead">
                <vs-th>#</vs-th>
                <vs-th>Data</vs-th>
                <vs-th>Produto</vs-th>
                <vs-th>Comissão</vs-th>
            </template>
            <template slot-scope="{ data }">
                <vs-tr :key="indextr" v-for="(comi, indextr) in data" class="table-line">
                    <vs-td :data="indextr + 1">{{ indextr + 1 }}</vs-td>
                    <vs-td :data="comi.date_sale">{{ dateFormat(comi.date_sale) }}</vs-td>
                    <vs-td :data="comi.product_name">{{ comi.product_name }}</vs-td>
                    <vs-td :data="comi.comission">{{ valueFormat(comi.comission_real) }}</vs-td>
                </vs-tr>
            </template>
        </vs-table>

        <!--PDF-->
        <VueHtml2pdf
                :show-layout="false"
                :float-layout="true"
                :enable-download="true"
                :preview-modal="true"
                :paginate-elements-by-height="1400"
                filename="myPDF"
                :pdf-quality="2"
                :manual-pagination="false"
                pdf-format="a4"
                pdf-orientation="landscape"
                pdf-content-width="100%"
                ref="html2Pdf"
            >
            <section slot="pdf-content">

                <div class="header_modal" style="padding: 40px; color:#000;">
                    <vs-row>
                        <vs-col vs-w="6">
                            <p style="color: #000 !important;"><b>Vendedor:</b> {{ seller.sellet_name }}</p>
                        </vs-col>
                        <vs-col vs-w="6">
                            <p style="color: #000 !important;"><b>Revenda:</b> {{ seller.enterprise_resale_name }}</p>
                        </vs-col>
                        <vs-col vs-w="6">
                            <p style="color: #000 !important;"><b>Representante:</b> {{ seller.enterprise_repre_name }}</p>
                        </vs-col>
                        <vs-col vs-w="6">
                            <p style="color: #000 !important;"><b>Total comissão:</b> {{ valueFormat(seller.total_comissions) }}</p>
                        </vs-col>
                    </vs-row>
                </div>
        
                <vs-table
                    stripe
                    :data="seller.comissions"
                    class="header"
                >
                    <template slot="thead">
                        <vs-th>#</vs-th>
                        <vs-th>Data</vs-th>
                        <vs-th>Produto</vs-th>
                        <vs-th>Comissão</vs-th>
                    </template>
                    <template slot-scope="{ data }">
                        <vs-tr :key="indextr" v-for="(comi, indextr) in data" class="table-line">
                            <vs-td :data="indextr + 1">{{ indextr + 1 }}</vs-td>
                            <vs-td :data="comi.date_sale">{{ dateFormat(comi.date_sale) }}</vs-td>
                            <vs-td :data="comi.product_name">{{ comi.product_name }}</vs-td>
                            <vs-td :data="comi.comission">{{ valueFormat(comi.comission) }}</vs-td>
                        </vs-tr>
                    </template>
                </vs-table>
            </section>
        </VueHtml2pdf>
        
    </div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'

export default {
    props: {
        seller: {
            type: Object,
            required: true,
            default: ()=>({})
        }
    },
    components:{VueHtml2pdf},
    methods: {
        valueFormat(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        },
     
        dateFormat(date) {
            if (!date) return '';
            return new Intl.DateTimeFormat('pt-BR').format(new Date(date));
        },

        downloadPDF(){
            
            this.$refs.html2Pdf.generatePdf()
        }
        
    },

};
</script>

<style>
    #modal_comissions p{
        color:#000 !important;
    }
    #modal_comissions .header_modal{
        padding: 20px;
    }
</style>