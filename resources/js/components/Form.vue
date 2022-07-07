<template>
    <vs-row vs-w="12" style="width: 100% !important; display: block;">
        <form @submit="checkForm" action="#">
            <template v-for="(form_item, index) in form_list">
                <vs-col vs-type="flex" vs-justify="center" vs-align="center" :vs-w="form_item.col" >
                    <div style="height: 72px; width: 95%;">

                        <p class="text-label">{{ form_item.label }}</p>

                        <!-- Texto Simples -->
                        <vs-input
                            v-if="form_item.type == 'text'"
                            :danger="form_item.active_message"
                            :danger-text="form_item.dangertext"
                            :placeholder="form_item.placeholder"
                            v-model="form_item.value"
                        />

                        <!-- Select -->
                        <vs-select
                            v-if="form_item.type == 'select'"
                            v-model="form_item.value"
                            :danger="form_item.active_message"
                            :danger-text="form_item.dangertext"
                        >
                            <vs-select-item :key="index" :value="item.id" :text="item.name" v-for="item,index in form_item.items" />
                        </vs-select>
                    </div>
                </vs-col>
            </template>
            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" >
                <vs-button class="mt-3" type="relief" @click="checkForm">Produtos</vs-button>
            </vs-col>
        </form>
    </vs-row>
</template>

<script>
export default {
    name: "Form",
    props:{
        form:{
            type: Array,
            default: []
        }
    },
    data(){
    return {
      value:'',
    }
  },
  methods:{
    checkForm(form){
        this.form_list = this.$c(this.form_list).map((item)=>{
            if(item.required && !item.value){
                item.active_message = true
                item.placeholder = item.placeholder+' '
            }else{
                item.placeholder = item.placeholder+' '
                item.active_message = false
            }
            return item
        }).all()
        return false
    }
  },
  computed:{
    form_list:{
        get() {
            let form = this.form
            form = this.$c(form).map((item)=>{
                if(!item.active_message){
                    item.active_message = false
                }
                return item;
            })
            return form.all()
        },
        set(newValue) {
            return newValue
        }
    }
  }
}
</script>

<style >
    .vs-con-input-label{
        width: 100% !important;
    }
    .text-label{
        margin-bottom: 3px;
    }
    .con-select {
        width: 100%;
        clear: both;
    }
</style>
