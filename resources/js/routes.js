import Home from './pages/Home'
import About from "./pages/About";
import NotFound from "./pages/NotFound";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Dashboard from "./pages/Dashboard";
import Investments from "./pages/Investments";
import LayoutFrontend from "./pages/LayoutFrontend";
import Layout from "./layout/Layout";

import Products from "./pages/products/Products";
import ProductView from "./pages/products/View";
import ProductRecord from "./pages/products/Record";

import Providers from "./pages/providers/Providers";
import ProviderView from "./pages/providers/View";
import ProviderRecord from "./pages/providers/Record";

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
                    component: Login,
                },
                {
                    path:'/register',
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
                    path:'/painel/produto/:id',
                    name: 'product_view',
                    component: ProductView
                },

                {
                    path:'/painel/fornecedores',
                    name: 'provides',
                    component: Providers
                },
                {
                    path:'/painel/fornecedores/novo',
                    name: 'provider_new',
                    component: ProviderRecord
                },
                {
                    path:'/painel/fornecedores/editar/:id',
                    name: 'provider_edit',
                    component: ProviderRecord
                },
                {
                    path:'/painel/fornecedores/:id',
                    name: 'provider_view',
                    component: ProviderView
                },


                {
                    path:'/about',
                    component: About
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
                            return next({ name: 'home'} )
                        })
                    }
                },
            ],
        },
    ]
}











