require("./bootstrap");

require("alpinejs");

window.Vue = require("vue").default;

import VueRouter from "vue-router";
Vue.use(VueRouter);

import App from "./components/App.vue";

import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);
import "sweetalert2/dist/sweetalert2.min.css";

import "@themesberg/flowbite";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faWindowClose,
    faEdit,
    faTrashAlt,
    faPlusSquare,
    faQuestionCircle
} from "@fortawesome/free-regular-svg-icons"; //edit, trash-alt, plus-square, question-circle -> far
//import { faAmazon } from "@fortawesome/free-brands-svg-icons"; //font-awesome ->fab
import {
    faTimes,
    faBars,
    faUserCog,
    faUserTag,
    faUserTie,
    faUserLock,
    faLaptopCode,
    faBuilding,
    faSave,
    faChartArea,
    faUser,
    faFolder,
    faBell,
    faHome,
    faAngleDown,
    faFileDownload,

} from "@fortawesome/free-solid-svg-icons";
/* times, bars, user-cog, user-tag, user-tie,
 *user-clock, laptop-code,building, save,
 *chart-area, user, folder ->fas**/
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
library.add(
    faWindowClose,
    faEdit,
    faTrashAlt,
    faPlusSquare,
    faQuestionCircle,
    faTimes,
    faBars,
    faUserCog,
    faUserTag,
    faUserTie,
    faUserLock,
    faLaptopCode,
    faBuilding,
    faSave,
    faChartArea,
    faUser,
    faFolder,
    faBell,
    faHome,
    faAngleDown,
    faFileDownload
);
Vue.component("font-awesome-icon", FontAwesomeIcon);

import ability from "./Services/Ability";
import { abilitiesPlugin } from "@casl/vue";
Vue.use(abilitiesPlugin, ability);

import auth from "./mixins/auth";
Vue.mixin(auth);
//Vue.prototype.$currentEmpresa = '0'

import VueCookies from "vue-cookies";
Vue.use(VueCookies);

import TailablePagination from "tailable-pagination";
Vue.use(TailablePagination);

/**********************Rutas *********************/
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
import Reportes from "./WebService/Rportes.vue";
import ReadZip from "./WebService/readZip.vue";

import Dashboard from "./components/layouts/Dashboard.vue"

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
            path: "/empresa/fiel",
            component: EmpresaFiel,
            name: "empresa.fiel"
        },
        {
            //web service
            path: "/procesamientoCFDI",
            component: ProcesamientoCFDI,
            name: "procesamiento"
        },
        {
            //web service
            path: "/procesamientoCFDI/reportes",
            component: Rportes,
            name: "reportes"
        },
        {
            //web service
            path: "/procesamientoCFDI/procesamiento",
            component: ReadZip,
            name: "readZip"
        },
        {
            //web service
            path: "/home",
            component: Dashboard,
            name: "Home"
        }
    ]
});

const app = new Vue({
    el: "#app",
    components: { App },
    router
});
