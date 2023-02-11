<template>
    <div id="shopping">

        <vs-navbar class="header_page">
            <div slot="title">
                <vs-navbar-title>
                    Pedidos de garantia
                </vs-navbar-title>
            </div>
            <vs-button type="relief" @click="popup_new = true">
                Cadastrar nova
            </vs-button>
        </vs-navbar>

        <div style="width:100%; float:left;" class="mt-4" id="warranties">
            <vs-tabs :color="colorx" alignment="fixed">

                <vs-tab @click="colorx = 'success'" label="Em Processo">
                    <div class="card_warranty" v-for="(w, i) in warranties" v-if="w.status == 1">
                        <vs-row>
                            <vs-col vs-w="6">
                                <p><b>N°:</b> {{ w.id }}</p>
                                <p><b>Produto:</b> {{ w.product.name }}</p>
                                <p><b>Comprador:</b> {{ w.chat.user.name }}</p>
                                <p><b>Data da solicitação:</b> {{ formatDate(w.created_at) }}</p>
                            </vs-col>
                            <vs-col vs-w="6" vs-type="flex" vs-justify="center" vs-align="center">
                                <vs-button type="relief" size="small" @click="$router.push({ name: 'warranty_chat', params: { id: w.id } })">Mensagens</vs-button>
                                <template v-if="$user.enterprise">
                                    <vs-button v-if="$user.enterprise.enterprise_type_id == 1" type="relief" color="success" class="m-2" size="small" @click="conclude(w.id)">Concluir</vs-button>
                                </template>
                            </vs-col>
                        </vs-row>
                    </div>
                    
                </vs-tab>

                <vs-tab @click="colorx = 'danger'" label="Concluídos">
                    <div class="card_warranty" v-for="(w, i) in warranties" v-if="w.status == 0">
                        <vs-row>
                            <vs-col vs-w="6">
                                <p><b>N°:</b> {{ w.id }}</p>
                                <p><b>Produto:</b> {{ w.product.name }}</p>
                                <p><b>Comprador:</b> {{ w.chat.user.name }}</p>
                                <p><b>Data da solicitação:</b> {{ formatDate(w.created_at) }}</p>
                            </vs-col>
                        </vs-row>
                    </div>
                </vs-tab>
    
            </vs-tabs>
        </div>

        <vs-popup title="Cadastrar garantia" :active.sync="popup_new">

            <vs-row id="record_warranty">

                <vs-col vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Cliente final</p>
                        <vs-select
                            v-model="form.user"
                            autocomplete
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in users" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-w="6" >
                    <div class="form_item">
                        <p class="text-label">Assistência técnica</p>
                        <vs-select
                            v-model="form.assistance"
                            autocomplete
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in assistances" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-w="12" >
                    <div class="form_item">
                        <p class="text-label">Produto</p>
                        <vs-select
                            v-model="form.product"
                            autocomplete
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in products" />
                        </vs-select>
                    </div>
                </vs-col>

                <vs-col vs-w="12">
                    <vs-button type="filled" @click="record">
                        <span>Cadastrar</span>
                    </vs-button>
                </vs-col>

            </vs-row>
        </vs-popup>
    
    </div>
</template>

<script>
export default {
    name: "Warranty",
    data(){
        return{
            colorx:'success',
            warranty_update: {},
            warranties: [],
            popup_new: false,
            assistances: [],
            products: [],
            users: [],
            form:{
                assistance: null,
                user: null,
                product: null,
            }
        }
    },
    methods:{

        conclude(id){

            this.warranty_update = this.$c(this.warranties).where('id', id).first()
            
            this.$vs.dialog({
                type: "confirm",
                color: "danger",
                title: `Confirme`,
                text:"Deseja concluir a garantia N° " + this.warranty_update.id + "?",
                accept: this.acceptConclude,
                acceptText: "Concluir",
                cancelText: "Cancelar",
            });
                
        },

        acceptConclude(){

            //loading
            this.$vs.loading({
                container: '#warranties',
                scale: 0.6
            })

            axios.put('/api/warranty/'+this.warranty_update.id, {status:0}).then((item)=>{

                this.getWarranties()

                //close loading
                setTimeout(() => {
                    this.$vs.loading.close("#warranties > .con-vs-loading");
                }, 1);  

                this.$vs.notify({
                    color:'success',
                    title:'Garantia concluída!',
                    text:''
                })
            })

        },

        record(){

            //loading
            this.$vs.loading({
                container: '#record_warranty',
                scale: 0.6
            })

            if(this.validation())
            {
                axios.post('/api/warranty', this.form).then((item)=>{

                    this.getWarranties()

                    this.popup_new = false

                    //close loading
                    setTimeout(() => {
                        this.$vs.loading.close("#warranties > .con-vs-loading");
                    }, 1);  

                    this.$vs.notify({
                        color:'success',
                        title:'Garantia cadastrada!',
                        text:''
                    })
                })

            }else{
                //close loading
                setTimeout(() => {
                    this.$vs.loading.close("#warranties > .con-vs-loading");
                }, 1);  
            }
        },

        validation(){
            let v = true

            if(!this.form.assistance || !this.form.user || !this.form.product){
                v = false
            }

            return v
        },

        getWarranties(){
            axios.get('/api/warranty').then((data)=>{
                this.warranties = data.data
            })
        },

        getProducts(){
            axios.get('/api/products-bermar').then((data)=>{
                this.products = data.data
            })
        },

        getAssitences(){
            axios.get('/api/enterprises-type/4').then((data)=>{
                this.assistances = data.data
            })
        },

        getUsers(){
            axios.get('/api/buyers').then((data)=>{
                this.users = data.data
            })
        },

        formatDate(date){
            let day = new Date(date)
            return day.toLocaleDateString("pt-BR")
        },

    },
    created() {
        this.getWarranties()
        this.getProducts()
        this.getAssitences()
        this.getUsers()
    },
}
</script>

<style scoped>
    .header_page{
        padding: 20px 10px;
    }
    .header_page h3{
        font-size: 20px;
        font-weight: 600;
    }
 
    .card_warranty{
        padding: 16px 18px;
        border: 1px solid #efeeee;
        margin: 30px 10px;
        border-radius: 8px;
        width: 100%;
        float: left;
        box-shadow: 0 4px 20px 0 rgb(0 0 0 / 5%);
    }
    .card_warranty p {
        margin: 0;
    }
    h5{
        text-align: center;
        float: left;
        width: 100%;
        padding: 20px 10px;
        font-size: 15px;
        margin-bottom: 16px;
    }
 
</style>
