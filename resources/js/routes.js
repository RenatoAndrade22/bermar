import Home from './pages/Home'
import About from "./pages/About";
import NotFound from "./pages/NotFound";
import Login from "./pages/Login";
import Register from "./pages/Register";
import RegisterSales from "./pages/RegisterSales.vue";
import Dashboard from "./pages/Dashboard";
import Investments from "./pages/Investments";
import LayoutFrontend from "./pages/LayoutFrontend.vue";
import Layout from "./layout/Layout";

import Products from "./pages/products/Products";
import ProductView from "./pages/products/View";
import ProductRecord from "./pages/products/Record";

import Company from "./pages/company/Company";
import CompanyRepre from "./pages/CompanyRepre/CompanyRepre";
import Comissions from "./pages/Comissions/Comissions";

import Sales from "./pages/sales/Sale";
import SalesExternal from "./pages/salesExternal/SalesExternal.vue";
import SalesExternalReport from "./pages/salesExternalReport/Report.vue";

import Warranty from "./pages/warranty/Warranty"

import Shopping from "./pages/shopping/Shopping";

import Chat from './pages/warranty/Chat'
import Categories from './pages/category/Categories'

import User from "./pages/users/User";

import WarrantyProduct from "./pages/warranty-products/WarrantyProduct"

import PriceTable from "./pages/price_table/PriceTable"
import PriceTableNew from "./pages/price_table/New"

import MethodPayment from "./pages/paymentMethod/paymentMethod"
import MethodPaymentNew from "./pages/paymentMethod/New"

export default {
    mode: 'history',
    linkActiveClass:'active-menu',

    routes:[
        {
            path:'*',
            component: NotFound
        },
        {
            path: '',
            component: LayoutFrontend,
            children: [
                {
                    path: 'login',
                    name: 'login',
                    component: Login,
                    meta:{
                        auth: false
                    }
                },
                {
                    path:'/cadastro',
                    name: 'cadastro',
                    component: Register,
                    meta:{
                        auth: false
                    }
                },
                {
                    path:'/cadastro/vendedores/:id',
                    name: 'cadastro-vendedores',
                    component: RegisterSales,
                    meta:{
                        auth: false
                    }
                },

            ],
        },
        {
            path: '/painel',
            component: Layout,
            base: '/painel',
            children: [
                {
                    path:'/painel',
                    component: Home,
                    name: 'home',
                    meta:{
                        auth: true
                    }
                },

                {
                    path:'/painel/produtos',
                    name: 'products',
                    component: Products,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/produtos/novo',
                    name: 'products_new',
                    component: ProductRecord,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/produtos/editar/:id',
                    name: 'product_edit',
                    component: ProductRecord,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/produtos/editar/status/:id',
                    name: 'product_edit_status',
                    component: ProductRecord,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/produto/:id',
                    name: 'product_view',
                    component: ProductView,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/familias',
                    name: 'categories',
                    component: Categories,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/empresas',
                    name: 'companies',
                    component: Company,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/tabelas-comissoes',
                    name: 'Comissions',
                    component: Comissions,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/representante-empresas',
                    name: 'companiesRepre',
                    component: CompanyRepre,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/usuarios',
                    name: 'users',
                    component: User,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/vendas',
                    name: 'sales',
                    component: Sales,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/vendas-externas',
                    name: 'sales-external',
                    component: SalesExternal,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/vendas-externas-relatorios',
                    name: 'sales-external',
                    component: SalesExternalReport,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/tabela-de-precos',
                    name: 'PriceTable',
                    component: PriceTable,
                    meta:{
                        auth: true
                    }
                },

                {
                    path:'/painel/tabela-de-precos/nova',
                    name: 'PriceTableNew',
                    component: PriceTableNew,
                    meta:{
                        auth: true
                    }
                },

                {
                    path:'/painel/motodo-de-pagamento',
                    name: 'MetodoPagamento',
                    component: MethodPayment,
                    meta:{
                        auth: true
                    }
                },

                {
                    path:'/painel/motodo-de-pagamento/nova',
                    name: 'NovoMetodoPagamento',
                    component: MethodPaymentNew,
                    meta:{
                        auth: true
                    }
                },
                
                {
                    path:'/painel/minhas-compras',
                    name: 'shopping',
                    component: Shopping,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/garantias',
                    name: 'warranty',
                    component: Warranty,
                    meta:{
                        auth: true
                    }
                },
                {
                    path:'/painel/garantia/:id',
                    name: 'warranty_chat',
                    component: Chat,
                    meta:{
                        auth: true
                    }
                },     
                {
                    path:'/painel/produtos/garantias',
                    name: 'Warranty_product',
                    component: WarrantyProduct,
                    meta:{
                        auth: true
                    }
                },           
                {
                    path:'/dashboard',
                    component: Dashboard,
                    name: 'dashboard',
                    meta:{
                        auth: true
                    }
                },
            ],
        },
    ]
}
