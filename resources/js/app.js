require("./bootstrap");

require("alpinejs");

window.Vue = require("vue").default;

import VueRouter from "vue-router";
Vue.use(VueRouter);

import App from "./components/App.vue";

import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);
import "sweetalert2/dist/sweetalert2.min.css";

import ability from './Services/Ability'
import { abilitiesPlugin } from '@casl/vue'
Vue.use(abilitiesPlugin, ability)

import auth from './mixins/auth'
Vue.mixin(auth);

import EmpresaIndex from "./Empresa/Index.vue";
import EmpresaCreate from "./Empresa/Create.vue";
import EmpresaEdit from "./Empresa/Edit.vue";
import EmpresaShow from "./Empresa/Show.vue";
import EmpresaFiel from "./Empresa/CreateFiel.vue";

import UserIndex from "./Users/Index.vue";
import UserCreate from "./Users/Create.vue";
import UserEdit from "./Users/Edit.vue";

import RoleIndex from "./Role/Index.vue";
import RoleCreate from "./Role/Create.vue";
import RoleEdit from "./Role/Edit.vue";

import PermissionIndex from "./Permission/Index.vue";
import PermissionCreate from "./Permission/Create.vue";
import PermissionEdit from "./Permission/Edit.vue";

import ProcesamientoCFDI from "./WebService/ProcesamientoCFDI.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            //Users
            path: "/user",
            component: UserIndex,
            name: "user.index"
        },
        {
            path: "/user/create",
            component: UserCreate,
            name: "user.create"
        },
        {
            path: "/user/edit/:id",
            component: UserEdit,
            name: "user.edit"
        },
        {
            //Role
            path: "/role",
            component: RoleIndex,
            name: "role.index"
        },
        {
            path: "/role/create",
            component: RoleCreate,
            name: "role.create"
        },
        {
            path: "/role/edit/:id",
            component: RoleEdit,
            name: "role.edit"
        },
        {
            //permission
            path: "/permission",
            component: PermissionIndex,
            name: "permission.index"
        },
        {
            path: "/permission/create",
            component: PermissionCreate,
            name: "permission.create"
        },
        {
            path: "/permission/edit/:id",
            component: PermissionEdit,
            name: "permission.edit"
        },
        {
            //empresa
            path: "/empresa",
            component: EmpresaIndex,
            name: "empresa.index"
        },
        {
            path: "/empresa/create",
            component: EmpresaCreate,
            name: "empresa.create"
        },
        {
            path: "/empresa/edit/:id",
            component: EmpresaEdit,
            name: "empresa.edit"
        },
        {
            path: "/empresa/show",
            component: EmpresaShow,
            name: "empresa.show"
        },
        {
            //fiel
            path: "/empresa/fiel/:id",
            component: EmpresaFiel,
            name: "empresa.fiel"
        },
        {
            //web service
            path: "/procesamientoCFDI",
            component: ProcesamientoCFDI,
            name: "procesamiento"
        }
    ]
});

const app = new Vue({
    el: "#app",
    components: { App },
    router
});
