<template>
    <div class="nav_c">
        <div class="logo">
            <img src="/images/logo.png" alt="">
        </div>
        <div class="menu">

            <router-link to="/painel">
                <UilAngleRight color="#626262" size="12px" class="icon_angle" />
                <UilEstate size="20px" class="icon_route" />
                Painel
            </router-link>

            <router-link to="/painel/produtos">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Produtos
            </router-link>

            <router-link to="/painel/fornecedores">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Fornecedores
            </router-link>

        </div>
    </div>

</template>

<script>

import { UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube } from '@iconscout/vue-unicons'

export default {
    name: "Nav",
    components:{ UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube },
}
</script>

<style scoped>
    .nav_c{
        width: 100%;
        float: left;
        text-align: center;
    }

    .menu{
        float: left;
        width: 100%;
    }
    .menu a{
        width: 100%;
        float: left;
        text-decoration: none;
        text-align: left;
        padding: 15px;
        font-weight: 700;
        font-size: 14px;
        color: #626262;
    }
    /*.active-menu{*/
    /*    background: #252936 !important;*/
    /*}*/
    .bullet{
        width: 4px;
        height: 4px;
        float: left;
        border-radius: 100%!important;
        background: #b5b5c3;
        margin-top: 8px;
        margin-right: 11px;
    }
    .logo{
        padding: 20px;
    }
    .logo img{
        width: 77%;
    }
    .logo h1{
        font-size: 29px;
        text-align: left;
        padding: 22px 30px;
    }
    .icon_route{
        margin: 0px 9px;
    }
</style>
