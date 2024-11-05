<template>
    <div>
        <vs-row>
            <vs-col vs-w="12">
                <div 
                    v-for="l in qntList" 
                    v-if="numberPage(l)"
                    :key="l"
                    :class=" numberPage(l) == current_page ? 'link_page current' : 'link_page' " 
                    @click="clickedLink(numberPage(l))"
                >
                    <p>{{ numberPage(l) }}</p>
                </div>
                <p style="float: left;margin-right: 8px;">...</p>
                <div 
                    v-if="viewLastButton()" 
                    class="link_page" 
                    @click="clickedLink(last_page)"
                >
                    <p>{{ last_page }}</p>
                </div>

                
            </vs-col>
        </vs-row>
    </div>
</template>

<script>

export default {
    name: "Pagination",

    props:{
        current_page:{
            type: Number,
            default: 0
        },
        last_page:{
            type: Number,
            default: 0
        },
        total:{
            type: Number,
            default: 0
        },
    },

    data() {
        return{
            list: 0,
            max: 5,
        }
    },

    created() {
    },

    methods: {
        clickedLink(i) {

            if (i == this.current_page) {
                return false
            }

            this.$emit('paginationClick', i)
        },

        numberPage(page){

            let i

            if (this.current_page < this.max) {
                return page
            }

            if (page == 1) {
                i = (this.current_page - 2)
            }

            if (page == 2) {
                i = (this.current_page - 1)
            }

            if (page == 3) {
                i = this.current_page
            }

            if (page == 4) {
                i = (this.current_page + 1)
            }

            if (page == 5) {
                i = (this.current_page + 2)
            }

            if (i > this.last_page) {
                i = false
            }


            return i
        },

        viewLastButton() {

            if (this.current_page >= (this.last_page - 2)) {
                return false
            }
            
            if (this.last_page > 6) {
                return true
            }
             
        }
    },

    computed:{
        qntList() {
            
            if (this.last_page < this.max) {
                return this.last_page
            }

            return this.max
        }
    }
}
</script>

<style scoped>
    .link_page{
        float: left;
        margin-right: 6px;
        cursor: pointer;
    }

    .link_page p{
        border: 1px solid #727891;
        padding: 1px 7px;
        margin: 0;
    }

    .current{
        background: #727891;
    }
    .current p{
        color: #fff !important;
    }
</style>
