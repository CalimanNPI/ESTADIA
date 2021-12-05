<template>
  <div class="flex flex-col">
      <router-link :to="{ name: 'permission.create' }" class="mr-4" exact
            >Crear permiso</router-link
          >
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
                <th>Guard</th>
                <th>Fecha de creación</th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Acciones</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="item in items"
                :key="item.id"
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
                  {{ item.name }}
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
                  {{ item.guard_name }}
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
                  {{ item.created_at }}
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
                      name: 'permission.edit',
                      params: { id: item.id },
                    }"
                    class="text-blue-600 hover:text-blue-900"
                    >Edit
                  </router-link>
                  <a
                    href="#"
                    @click="delete_permission(item.id)"
                    class="
                      shadow
                      bg-red-500
                      hover:bg-red-400
                      focus:shadow-outline focus:outline-none
                      text-white
                      font-bold
                      py-1
                      px-2
                      rounded
                    "
                    >Borar</a
                  >
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
      items: [],
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios
        .get("/api/permission")
        .then((response) => {
          this.items = response.data;
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Se produjo un Error",
            text: "error en : " + err,
          });
        });
    },
    delete_permission(id) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("/api/permission/" + id)
            .then((result) => {
              this.$swal({ icon: "sucess", title: "Delete successfully" });
              this.getResults();
            })
            .catch((err) => {
              this.$swal({ icon: "error", title: "Error Happened" });
            });
        }
      });
    },
  },
};
</script>
