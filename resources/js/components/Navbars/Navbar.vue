<template>
  <!-- Navbar -->
  <nav
    class="
      absolute
      top-0
      left-0
      w-full
      z-10
      bg-transparent
      md:flex-row md:flex-nowrap md:justify-start
      flex
      items-center
      p-4
    "
  >
    <div
      class="
        w-full
        mx-autp
        items-center
        flex
        justify-between
        md:flex-nowrap
        flex-wrap
        md:px-10
        px-4
      "
    >
      <!-- Brand -->
      <a
        class="
          text-gray-800 text-sm
          uppercase
          hidden
          lg:inline-block
          font-semibold
        "
        href="javascript:void(0)"
      >
        Dashboard
      </a>
      <a
        class="text-gray-800 text-sm uppercase lg:inline-block font-semibold"
        href="javascript:void(0)"
        v-on:click="toggleModalLarge()"
      >
        Mis Empresas
      </a>

      <!-- User -->
      <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
        <UserDropdown />
      </ul>
    </div>

    <div
      v-if="showModal"
      class="
        overflow-x-hidden overflow-y-auto
        fixed
        inset-0
        z-50
        outline-none
        focus:outline-none
        justify-center
        items-center
        flex
      "
    >
      <div class="relative w-auto my-6 mx-auto max-w-6xl">
        <!--content-->
        <div
          class="
            border-0
            rounded-lg
            shadow-lg
            relative
            flex flex-col
            w-full
            bg-white
            outline-none
            focus:outline-none
          "
        >
          <!--header-->
          <div
            class="
              flex
              items-start
              justify-between
              p-5
              border-b border-solid border-gray-200
              rounded-t
            "
          >
            <h3 class="text-3xl font-semibold">Seleccione una empresa</h3>
            <button
              class="
                p-1
                ml-auto
                border-0
                text-black
                float-right
                text-3xl
                leading-none
                font-semibold
                outline-none
                focus:outline-none
              "
              v-on:click="toggleModalLarge()"
            >
              <span
                class="
                  text-gray-800
                  h-6
                  w-6
                  text-2xl
                  block
                  outline-none
                  focus:outline-none
                "
              >
                ×
              </span>
            </button>
          </div>
          <!--body-->
          <div class="relative p-6">
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
          </div>
          <!--footer-->
          <div
            class="
              flex
              items-center
              justify-end
              p-6
              border-t border-solid border-blueGray-200
              rounded-b
            "
          >
            <button
              class="
                text-red-500
                background-transparent
                font-bold
                uppercase
                px-6
                py-2
                text-sm
                outline-none
                focus:outline-none
                mr-1
                mb-1
                ease-linear
                transition-all
                duration-150
              "
              type="button"
              v-on:click="toggleModalLarge()"
            >
              Close
            </button>
            <!--  <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleModal()">
              Save Changes
            </button> -->
          </div>
        </div>
      </div>
    </div>
    <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
import UserDropdown from "../Dropdowns/UserDropdown.vue";
import EmpresaShow from '../../Empresa/Show.vue'

export default {
  components: {
    UserDropdown,
    EmpresaShow
  },
  data() {
    return {
      showModal: false,
      empresas: [],
      active: "",
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    toggleModalLarge: function () {
      this.showModal = !this.showModal;
    },
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
  },
};
</script>
