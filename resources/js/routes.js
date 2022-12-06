import Home from './pages/Home'
import About from "./pages/About";
import NotFound from "./pages/NotFound";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Dashboard from "./pages/Dashboard";
import Investments from "./pages/Investments";
import LayoutFrontend from "./pages/LayoutFrontend.vue";
import Layout from "./layout/Layout";

import Products from "./pages/products/Products";
import ProductView from "./pages/products/View";
import ProductRecord from "./pages/products/Record";

import Company from "./pages/company/Company";

import Sales from "./pages/sales/Sale";

import Warranty from "./pages/warranty/Warranty"

import Shopping from "./pages/shopping/Shopping";

import Chat from './pages/warranty/Chat'
import Categories from './pages/category/Categories'

import User from "./pages/users/User";

import WarrantyProduct from "./pages/warranty-products/WarrantyProduct"

import PriceTable from "./pages/price_table/PriceTable"
import PriceTableNew from "./pages/price_table/New"

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
                },
                {
                    path:'/cadastro',
                    name: 'cadastro',
                    component: Register
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
                    name: 'home'
                },

                {
                    path:'/painel/produtos',
                    name: 'products',
                    component: Products
                },
                {
                    path:'/painel/produtos/novo',
                    name: 'products_new',
                    component: ProductRecord
                },
                {
                    path:'/painel/produtos/editar/:id',
                    name: 'product_edit',
                    component: ProductRecord
                },
                {
                    path:'/painel/produtos/editar/status/:id',
                    name: 'product_edit_status',
                    component: ProductRecord
                },
                {
                    path:'/painel/produto/:id',
                    name: 'product_view',
                    component: ProductView
                },
                {
                    path:'/painel/familias',
                    name: 'categories',
                    component: Categories
                },
                {
                    path:'/painel/empresas',
                    name: 'companies',
                    component: Company
                },
                {
                    path:'/painel/usuarios',
                    name: 'users',
                    component: User
                },
                {
                    path:'/painel/vendas',
                    name: 'sales',
                    component: Sales
                },
                {
                    path:'/painel/tabela-de-precos',
                    name: 'PriceTable',
                    component: PriceTable
                },

                {
                    path:'/painel/tabela-de-precos/nova',
                    name: 'PriceTableNew',
                    component: PriceTableNew
                },
                
                {
                    path:'/painel/minhas-compras',
                    name: 'shopping',
                    component: Shopping
                },
                {
                    path:'/painel/garantias',
                    name: 'warranty',
                    component: Warranty
                },
                {
                    path:'/painel/garantia/:id',
                    name: 'warranty_chat',
                    component: Chat
                },     
                {
                    path:'/painel/produtos/garantias',
                    name: 'Warranty_product',
                    component: WarrantyProduct
                },           
                {
                    path:'/dashboard',
                    component: Dashboard,
                    name: 'dashboard',

                    beforeEnter:(to, from, next) => {
                        axios.get('/api/athenticated').then((user) => {
                            console.log('userr', user)
                            next()
                        }).catch((error)=>{
                            return next({ name: 'login'})
                        })
                    }
                },
            ],
        },
    ]
}











