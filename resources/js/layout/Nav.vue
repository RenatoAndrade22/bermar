<template>
    <div class="nav_c">
        <div class="logo">
            <img src="/images/logo.png" alt="">
        </div>
        <div class="menu">
            <router-link to="/painel" v-if="$user.enterprise.enterprise_type_id == 1" >
                <UilAngleRight color="#626262" size="12px" class="icon_angle" />
                <UilEstate size="20px" class="icon_route" />
                Painel
            </router-link>
            <router-link to="/painel/produtos" v-if="$user.enterprise.enterprise_type_id == 2 || $user.enterprise.enterprise_type_id == 1">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Produtos
            </router-link>
            <router-link to="/painel/categorias" v-if="$user.enterprise.enterprise_type_id == 1">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Categorias
            </router-link>
            <router-link to="/painel/vendas" v-if="$user.enterprise.enterprise_type_id == 1">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilTagAlt size="20px" class="icon_route" />
                Minhas Vendas
            </router-link>

            <router-link to="/painel/empresas" v-if="$user.enterprise.enterprise_type_id == 1">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShop size="20px" class="icon_route" />
                Empresas
            </router-link>

            <router-link to="/painel/usuarios" v-if="$user.enterprise.enterprise_type_id == 1">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilUsersAlt size="20px" class="icon_route" />
                Usuários
            </router-link>

            <router-link to="/painel/minhas-compras" v-if="$user.enterprise.enterprise_type_id == 1">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Minhas compras
            </router-link>

            <router-link to="/painel/garantias" v-if="$user.enterprise.enterprise_type_id == 1 || $user.enterprise.enterprise_type_id == 2">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Pedidos de garantia
            </router-link>
            
        </div>
    </div>
</template>

<script> 

import { UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube, UilShop, UilTagAlt, UilShoppingBag } from '@iconscout/vue-unicons'

export default {
    name: "Nav",
    components:{ UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube, UilShop, UilTagAlt, UilShoppingBag  },
    return:{
        data(){
            user: null
        }
    },
    created() {
        if (localStorage.user) {
        this.user = JSON.parse(localStorage.user);
        }
  },
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
