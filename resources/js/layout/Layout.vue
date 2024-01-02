<template>
    <div id="main">
        <div class="nav">
            <Nav></Nav>
        </div>
        <div class="content">
            <div class="header">
                
                <p><span @click.stop.prevent="getTeste()">{{ userName }}</span> - <span class="logout" @click="logout">sair</span></p>
            </div>
            <div class="box">
                <transition name="fade" mode="out-in">
                    <router-view />
                </transition>
            </div>
        </div>
    </div>
</template>


<script>
import Nav from "./Nav";
import Footer from "./Footer";

export default {
    name: "Layout",
    components:{
        Nav, Footer
    },
    data(){
        return{
            user_name: null,
        }
    },
    methods:{
        logout(){
            axios.post('/api/logout').then((item)=>{
                localStorage.removeItem('user')
                localStorage.removeItem('token')

                this.$store.commit('updateUserName', null);
                this.$store.commit('updateUserRules', null);

                this.$router.push({ name: "login" });
            })
        }
    },
    created(){
    },

    computed: {
        userName() {
            return this.$store.state.userName;
        },
    },
}
</script>

<style>
    #main{
        background: #f4f7fa !important;
        float: left;
        width: 100%;
    }
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s ease;
    }


    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }

    .box{
        width: 100%;
        float: left;
        padding: 20px;
        background: #ffffff;
    }
    .header{
        width: 100%;
        float: left;
        padding: 20px;
        background: #ffffff;
        margin-bottom: 14px;
    }
    .header p{
        margin: 0;
        float: right;
    }
    .logout{
        cursor: pointer;
    }
</style>
