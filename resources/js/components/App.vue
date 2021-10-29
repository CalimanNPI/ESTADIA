<template>
  <div>
    <!--<router-link exact to="/">Ver blog</router-link>
     <router-link exact to="/blog/create">Crear blog</router-link>-->

    <div class="flex bg-gray-100 border-b border-gray-300 py-4">
      <div class="container mx-auto flex justify-between">
        <div class="flex">
          <router-link :to="{ name: 'blog.index' }" class="mr-4" exact
            >Ver blog</router-link
          >
          <router-link :to="{ name: 'blog.create' }" class="mr-4" exact
            >Crear blog</router-link
          >
          <router-link :to="{ name: 'empresa.index' }" class="mr-4" exact
            >Ver empresa</router-link
          >
          <router-link :to="{ name: 'empresa.create' }" class="mr-4" exact
            >Crear empresa</router-link
          >
          <router-link :to="{ name: 'procesamiento' }" class="mr-4" exact
            >Procesamiento CFDI</router-link
          >
        </div>
      </div>
    </div>
    <div
      class="md:w-custom mx-auto py-8 md:flex md:justify-between md:flex-wrap"
    >
      <div v-for="empresa in empresas" :key="empresa.idempresa">
        <EmpresaShow
          :id="empresa.idempresa"
          :nombre="empresa.nombre"
          :razonsocial="empresa.razonsocial"
          :rfc="empresa.rfc"
          v-model="active"
        ></EmpresaShow>
      </div>
    </div>

     <button class="px-6 py-3 bg-red-600 text-gray-100 rounded shadow" id="delete-btn">
        Delete 
    </button>

    <div class="bg-black bg-opacity-50 absolute inset-0 hidden justify-center items-center" id="overlay">
        <div class="bg-gray-200 max-w-sm py-2 px-3 rounded shadow-xl text-gray-800">
            <div class="flex justify-between items-center">
                <h4 class="text-lg font-bold">Confirm Delete?</h4>
                <svg class="h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full" id="close-modal" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="mt-2 text-sm">
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maiores, sunt.</p>
            </div>
            <div class="mt-3 flex justify-end space-x-3">
                <button class="px-3 py-1 rounded hover:bg-red-300 hover:bg-opacity-50 hover:text-red-900">Cancel</button>
                <button class="px-3 py-1 bg-red-800 text-gray-200 hover:bg-red-600 rounded">Delete</button>
            </div>
        </div>
    </div>

    <router-view></router-view>
  </div>
</template>
<script>
import EmpresaShow from "../Empresa/Show.vue";

export default {
  data() {
    return {
      empresas: [],
      active: "",
    };
  },
  components: {
    EmpresaShow,
  },
  mounted() {
    this.getResults();
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
    setEmpresa(id) {
      axios
        .get("/empresa/global/" + id)
        .then((result) => {
          console.log(result);
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Se produjo un Error",
            text: "error en : " + err,
          });
        });
    },
  },
};

 window.addEventListener('DOMContentLoaded', () =>{
            const overlay = document.querySelector('#overlay')
            const delBtn = document.querySelector('#delete-btn')
            const closeBtn = document.querySelector('#close-modal')

            const toggleModal = () => {
                overlay.classList.toggle('hidden')
                overlay.classList.toggle('flex')
            }

            delBtn.addEventListener('click', toggleModal)

            closeBtn.addEventListener('click', toggleModal)
        })
</script>



