<template>
    <div id="main">
        <div class="nav">
            <Nav />
        </div>
        <div class="content">
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
        padding: 20px;
        background: #ffffff;
    }
</style>
