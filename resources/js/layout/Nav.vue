<template>
    <div class="nav_c">
        <div class="logo">
            <img src="/images/logo.png" alt="">
        </div>
        <div class="menu">
            
            <router-link to="/painel" v-if="pages.includes('painel')">
                <UilAngleRight color="#626262" size="12px" class="icon_angle" />
                <UilEstate size="20px" class="icon_route" />
                Painel
            </router-link>

            <!--
            <router-link to="/painel/tabela-de-precos" v-if="[1].includes(user_type)">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Tabela de preço
            </router-link>
            <router-link to="/painel/motodo-de-pagamento" v-if="[1].includes(user_type)">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilTagAlt size="20px" class="icon_route" />
                Metodos de pagamento
            </router-link>
            -->
            

            <router-link to="/painel/produtos" v-if="pages.includes('produtos')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Produtos
            </router-link>

            <router-link to="/painel/familias" v-if="pages.includes('familias')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Família
            </router-link>
            <!--
            <router-link to="/painel/vendas" v-if="pages.includes('vendas')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilTagAlt size="20px" class="icon_route" />
                Minhas Vendas
            </router-link>
            -->
            

            <router-link to="/painel/vendas" v-if="pages.includes('vendas')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilTagAlt size="20px" class="icon_route" />
                Vendas
            </router-link>

            <router-link to="/painel/tabelas-comissoes" v-if="pages.includes('tabelas-comissoes')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Comissões
            </router-link>

            <router-link to="/painel/vendas-externas-relatorios" v-if="pages.includes('vendas-externas-relatorios')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Vendas externas
            </router-link>

            <router-link to="/painel/empresas" v-if="pages.includes('empresas')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShop size="20px" class="icon_route" />
                Empresas
            </router-link>

            <router-link to="/painel/usuarios" v-if="pages.includes('usuarios')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilUsersAlt size="20px" class="icon_route" />
                Usuários
            </router-link>

            <router-link to="/painel/minhas-compras" v-if="pages.includes('minhas-compras')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Minhas compras
            </router-link>

            <router-link to="/painel/garantias" v-if="pages.includes('garantias')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Pedidos de garantia
            </router-link>

            <router-link to="/painel/produtos/garantias" v-if="pages.includes('produtos/garantias')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Produtos de garantia
            </router-link>

            <router-link to="/painel/vendas-externas" v-if="pages.includes('vendas-externas')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Vendas externas
            </router-link>

            <router-link to="/painel/representante-empresas" v-if="pages.includes('representante-empresas')">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Empresas
            </router-link>
        </div>
    </div>
</template>

<script>

import { UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube, UilShop, UilTagAlt, UilShoppingBag } from '@iconscout/vue-unicons'

export default {
    name: "Nav",
    components:{ UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube, UilShop, UilTagAlt, UilShoppingBag  },
    
  data(){
    return{}
  },
    
  methods: {},

  computed: {
    pages() {
        return this.$store.state.pages;
    },
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
