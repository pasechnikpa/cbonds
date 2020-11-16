require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import ProductsIndex from './components/products/ProductsIndex.vue';
import ProductsForm from './components/products/ProductsForm.vue';

const routes = [
    {
        path: '/',
        components: {
            companiesIndex: ProductsIndex
        }
    },
    {path: '/product/create', component: ProductsForm, name: 'createProduct'},
    {path: '/productedit/:id', component: ProductsForm, name: 'editProduct'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')