<template>
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg shadow-md">
          <table class="min-w-full">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="
                    text-xs
                    font-medium
                    text-gray-700
                    px-6
                    py-3
                    text-left
                    uppercase
                    tracking-wider
                  "
                >
                  Nombre
                </th>
                <th
                  scope="col"
                  class="
                    text-xs
                    font-medium
                    text-gray-700
                    px-6
                    py-3
                    text-left
                    uppercase
                    tracking-wider
                  "
                >
                  Razón Social
                </th>
                <th
                  scope="col"
                  class="
                    text-xs
                    font-medium
                    text-gray-700
                    px-6
                    py-3
                    text-left
                    uppercase
                    tracking-wider
                  "
                >
                  RFC
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Acciones</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="empresa in empresas"
                :key="empresa.idempresa"
                class="bg-white border-b"
              >
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-sm
                    font-medium
                    text-gray-900
                  "
                >
                  {{ empresa.nombre }}
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-sm
                    font-medium
                    text-gray-900
                  "
                >
                  {{ empresa.razonsocial }}
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-sm
                    font-medium
                    text-gray-900
                  "
                >
                  {{ empresa.rfc }}
                </td>
                <td
                  class="
                    px-6
                    py-4
                    whitespace-nowrap
                    text-sm
                    font-medium
                    text-gray-900
                  "
                >
                  <router-link
                    :to="{
                      name: 'empresa.edit',
                      params: { id: empresa.idempresa },
                    }"
                    class="text-blue-600 hover:text-blue-900"
                  >Edit
                  </router-link>

                  <router-link
                    :to="{
                      name: 'empresa.fiel',
                      params: { id: empresa.idempresa },
                    }"
                    class="text-blue-600 hover:text-blue-900"
                    >Fiel
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      empresas: [],
    };
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
  },
};
</script>