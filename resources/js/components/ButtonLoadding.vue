<template>
    <div>
        <vs-button type="relief" @click="sendData">
            {{ value_button }}
        </vs-button>
    </div>
</template>

<script>
export default {
    name: "SaleComponent",
    props:{
        value:{
            type: Boolean,
            default(rawProps) {
                return false
            }
        },
        id_loadding:{
            type: String,
            default(rawProps) {
                return ''
            }
        },
        name_button:{
            type: String,
            default(rawProps) {
                return ''
            }
        }
    },

    methods:{
        sendData(){
            this.$emit('send', '')
        }
    },

    computed:{

        value_button(){

            if(this.value){
                //loading
                this.$vs.loading({
                    container: '#'+this.id_loadding,
                    scale: 0.6
                })

            }else{            

                setTimeout(() => {
                    this.$vs.loading.close("#"+this.id_loadding+" > .con-vs-loading");
                }, 1)
            }
            return this.name_button
        }

    }
    
}
</script>