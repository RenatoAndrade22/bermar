<template>
    <div id="main">
        <div class="nav">
            <Nav />
        </div>
        <div class="content">
            <div class="header">
                
                <p><span @click.stop.prevent="getTeste()">{{$user.name}}</span> - <span class="logout" @click="logout">sair</span></p>
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
            axios.post('http://bermar.pgv/api/logout').then((item)=>{
                localStorage.removeItem('user')
                localStorage.removeItem('token')
                this.$user.name = null
                this.$router.push({ name: "login" });
            })
        }
    },
    created(){
    }
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
