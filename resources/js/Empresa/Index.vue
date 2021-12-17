<template>
  <div class="flex flex-col">
    <Link
      color="blue"
      iconName="plus-square"
      value="Crear empresa"
      :link="{ name: 'empresa.create' }"
    />

    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg shadow-md">
          <table class="min-w-full">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                  Nombre
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                  Razón Social
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
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
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ empresa.nombre }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ empresa.razonsocial }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ empresa.rfc }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  <Link
                    color="blue"
                    iconName="font-awesome"
                    value="Fiel"
                    :link="{
                      name: 'empresa.fiel',
                      params: { id: empresa.idempresa },
                    }"
                  />

                  <Link
                    color="blue"
                    iconName="edit"
                    value="Edit"
                    :link="{
                      name: 'empresa.edit',
                      params: { id: empresa.idempresa },
                    }"
                  />
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
import Button from "../components/Button.vue";
import Link from "../components/Link.vue";
export default {
  components: { Button, Link },
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
