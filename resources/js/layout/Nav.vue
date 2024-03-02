<template>
    <div class="nav_c">
        <div class="logo">
            <img src="/images/logo.png" alt="">
        </div>
        <div class="menu">
            
            <router-link to="/painel" v-if="nav.painel" >
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
            

            <router-link to="/painel/produtos" v-if="nav.produtos" id="nav-produtos">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Produtos
            </router-link>

            <router-link to="/painel/familias" v-if="nav.familia">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilCube size="20px" class="icon_route" />
                Família
            </router-link>

            <router-link to="/painel/vendas" v-if="nav.vendas">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilTagAlt size="20px" class="icon_route" />
                Minhas Vendas
            </router-link>

            <router-link to="/painel/vendas" v-if="nav.vendas_admin">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilTagAlt size="20px" class="icon_route" />
                Vendas
            </router-link>

            <router-link to="/painel/empresas" v-if="nav.empresas">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShop size="20px" class="icon_route" />
                Empresas
            </router-link>

            <router-link to="/painel/usuarios" v-if="nav.usuarios">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilUsersAlt size="20px" class="icon_route" />
                Usuários
            </router-link>

            <router-link to="/painel/minhas-compras" v-if="nav.minhas_compras">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Minhas compras
            </router-link>

            <router-link to="/painel/garantias" v-if="nav.pedidos_garantia">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Pedidos de garantia
            </router-link>

            <router-link to="/painel/produtos/garantias" v-if="nav.produtos_garantia">
                <UilAngleRight size="12px" class="icon_angle" />
                <UilShoppingBag size="20px" class="icon_route" />
                Produtos de garantia
            </router-link>

        </div>
    </div>
</template>

<script>

import { UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube, UilShop, UilTagAlt, UilShoppingBag } from '@iconscout/vue-unicons'
import Vuex from 'vuex';

export default {
    name: "Nav",
    components:{ UilEstate, UilAngleRight, UilUsersAlt, UilFileContractDollar, UilCube, UilShop, UilTagAlt, UilShoppingBag  },
    
    data(){
        return{
            nav: {
                produtos_garantia_rules: [1],
                produtos_garantia: false,

                pedidos_garantia_rules: [0,1,4],
                pedidos_garantia: false,

                minhas_compras_rules: [2],
                minhas_compras: false,

                usuarios_rules: [1],
                usuarios: false,

                empresas_rules: [1],
                empresas: false,
                
                vendas_rules: [3],
                vendas: false,

                vendas_admin_rules: [1],
                vendas_admin: false,
                
                familia_rules: [1],
                familia: false,

                produtos_rules: [1, 2],
                produtos: false,
                
                painel_rules: [0, 1, 3, 4],
                painel: false,
            },

            user_type: null
        }
    },
    
    created() {
    

            this.nav.painel            = this.validarRegrasUsuario(this.nav.painel_rules)
            this.nav.produtos          = this.validarRegrasUsuario(this.nav.produtos_rules)
            this.nav.familia           = this.validarRegrasUsuario(this.nav.familia_rules)
            this.nav.vendas_admin      = this.validarRegrasUsuario(this.nav.vendas_admin_rules)
            this.nav.vendas            = this.validarRegrasUsuario(this.nav.vendas_rules)
            this.nav.empresas          = this.validarRegrasUsuario(this.nav.empresas_rules)
            this.nav.usuarios          = this.validarRegrasUsuario(this.nav.usuarios_rules)
            this.nav.minhas_compras    = this.validarRegrasUsuario(this.nav.minhas_compras_rules)
            this.nav.pedidos_garantia  = this.validarRegrasUsuario(this.nav.pedidos_garantia_rules)
            this.nav.produtos_garantia = this.validarRegrasUsuario(this.nav.produtos_garantia_rules)
 
  },

  methods: {
    validarRegrasUsuario($regras){
        let rule = this.$c(this.userRules).filter((item)=>{
            return $regras.includes(item.enterprise_type_id)
        })
        return rule.count()
    },
  },

  computed: {
    userRules() {
        return this.$store.state.userRules;
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
