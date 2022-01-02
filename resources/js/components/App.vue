<template>
  <div>
    <!--<router-link exact to="/">Ver blog</router-link>
     <router-link exact to="/blog/create">Crear blog</router-link>-->
    <!-- <div class="flex bg-gray-100 border-b border-gray-300 py-4">
      <div class="container mx-auto flex justify-between">
        <div class="flex">
          <router-link :to="{ name: 'permission.index' }" class="mr-4" exact
            >Ver permission</router-link
          >

          <router-link :to="{ name: 'role.index' }" class="mr-4" exact
            >Ver role</router-link
          >
          <router-link :to="{ name: 'user.index' }" class="mr-4" exact
            >Ver usuarios</router-link
          >

          <router-link :to="{ name: 'empresa.index' }" class="mr-4" exact
            >Ver empresa</router-link
          >

          <router-link :to="{ name: 'procesamiento' }" class="mr-4" exact
            >Procesamiento CFDI</router-link
          >
          <router-link
            v-if="$can('web_service')"
            :to="{ name: 'procesamiento' }"
            class="mr-4"
            exact
            >Procesamiento CFDI</router-link
          >
          <a href="#" class="modal-open" @click="showEmpresas()">Empresas</a>
        </div>
      </div>
    </div>
    <Dashboard />

    <template id="my-template">
      <div class="flex flex-wrap justify-evenly">
        <EmpresaShow
          v-for="empresa in empresas"
          :key="empresa.idempresa"
          :id="empresa.idempresa"
          :nombre="empresa.nombre"
          :razonsocial="empresa.razonsocial"
          :rfc="empresa.rfc"
          v-model="active"
        ></EmpresaShow>
      </div>
    </template> -->

    <Sidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <Navbar />
      <Header/>
      <div class="px-4 md:px-10 mx-auto w-full -m-24">
        <p>{{ ability }}</p>
        <Footer/>
      </div>
    </div>
  </div>
</template>
<script>
import EmpresaShow from "../Empresa/Show.vue";
import Dashboard from "./layouts/Dashboard.vue";
import Footer from "./Footers/Footer.vue";
import Header from "./Headers/HeaderStats.vue";
import Navbar from "./Navbars/Navbar.vue";
import Sidebar from "./Sidebars/Sidebar.vue";
export default {
  components: { EmpresaShow, Dashboard, Footer, Header, Navbar, Sidebar },
  data() {
    return {
      empresas: [],
      active: "",
      ability: [],
      sidebarLinks: [
        { title: "Dashboard", icon: "dashboard", path: { name: "dashboard" } },
        {
          title: "User management",
          icon: "person",
          path: { name: "dashboard" },
          gate: "user_management_access",
          children: [
            {
              title: "Permissions",
              icon: "dashboard",
              path: { name: "permission.index" },
              gate: "permission_index",
            },
            {
              title: "Roles",
              icon: "dashboard",
              path: { name: "role.index" },
              gate: "role_index",
            },
            {
              title: "User",
              icon: "dashboard",
              path: { name: "user.index" },
              gate: "user_index",
            },
          ],
        },
        {
          title: "Company management",
          icon: "person",
          path: { name: "dashboard" },
          gate: "company_management_access",
          children: [
            {
              title: "Company",
              icon: "dashboard",
              path: { name: "empresa.index" },
              gate: "empresa_index",
            },
            {
              title: "Create FIEL",
              icon: "dashboard",
              path: { name: "empresa.fiel" },
              gate: "empresa_fiel",
            },
          ],
        },
        {
          title: "CFDIs processing",
          icon: "person",
          path: { name: "procesamiento" },
          gate: "web_service",
          children: [],
        },
        {
          title: "Reports",
          icon: "person",
          path: { name: "reports" },
          gate: "reports",
          children: [],
        },
      ],
    };
  },
  mounted() {
    this.getResults();
    this.getPermission();
  },
  methods: {
    getResults() {
      axios
        .get("/api/empresa")
        .then((response) => {
          this.empresas = response.data;
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Se produjo un Error",
            text: "error en : " + err,
          });
        });
    },
    getPermission() {
      axios
        .get("/api/ability")
        .then((response) => {
          console.log(response.data);
          //   this.ability.update([
          //       {subject:'all', actions: response.data}
          //   ])
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Se produjo un Error",
            text: "error en : " + err,
          });
        });
    },
    showEmpresas() {
      this.$swal({ title: "Seleccione una empresa", template: "#my-template" });
    },
  },
};
</script>

