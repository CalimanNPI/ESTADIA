require('./bootstrap');

require('alpinejs');

window.Vue = require('vue').default;

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueSweetalert2 from "vue-sweetalert2"
Vue.use(VueSweetalert2)
import "sweetalert2/dist/sweetalert2.min.css"

import App from './components/App.vue'
import CommentsIndex from './Comments/Index.vue'
import CommentsCreate from './Comments/Create.vue'
import CommentsEdit from './Comments/Edit.vue'

import EmpresaIndex from './Empresa/Index.vue'
import EmpresaCreate from './Empresa/Create.vue'
import EmpresaEdit from './Empresa/Edit.vue'
import EmpresaShow from './Empresa/Show.vue'
import EmpresaFiel from './Empresa/CreateFiel.vue'

import ProcesamientoCFDI from './WebService/ProcesamientoCFDI.vue'


const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: CommentsIndex,
      name: 'blog.index'
    },
    {
      path: '/blog/create',
      component: CommentsCreate,
      name: 'blog.create',
    },
    {
      path: '/blog/edit/:id',
      component: CommentsEdit,
      name: 'blog.edit',
    },
    //empresa
    {
      path: '/empresa',
      component: EmpresaIndex,
      name: 'empresa.index'
    },
    {
      path: '/empresa/create',
      component: EmpresaCreate,
      name: 'empresa.create',
    },
    {
      path: '/empresa/edit/:id',
      component: EmpresaEdit,
      name: 'empresa.edit',
    },
    {
      path: '/empresa/show',
      component: EmpresaShow,
      name: 'empresa.show',
    },//fiel
    {
      path: '/empresa/fiel/:id',
      component: EmpresaFiel,
      name: 'empresa.fiel',
    },//web service
    {
      path:'/procesamientoCFDI',
      component:ProcesamientoCFDI,
      name: 'procesamiento'
    }
  ]
})

//Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
  el: '#app',
  components: { App },
  router
});