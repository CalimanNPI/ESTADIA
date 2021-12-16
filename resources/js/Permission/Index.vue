<template>
  <div class="flex flex-col">
    <Link
      color="blue"
      iconName="font-awesome"
      value="Crear permiso"
      :link="{ name: 'permission.create' }"
    />
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg shadow-md">
          <table class="min-w-full">
            <thead class=" bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">Nombre</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">Guard</th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Acciones</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="item in items"
                :key="item.id"
                class="
                  bg-white
                  border-b
                "
              >
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ item.name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ item.guard_name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                  <Link
                    color="blue"
                    iconName="font-awesome"
                    value="Editar"
                    :link="{ name: 'permission.edit', params: { id: item.id } }"
                  />
                  <Button
                    color="red"
                    iconName="font-awesome"
                    value="Eliminar"
                    @click="delete_permission(item.id)"
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
import Badge from "../components/Badge.vue";
import Button from "../components/Button.vue";
import Link from "../components/Link.vue";
export default {
  components: { Button, Link, Badge },
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
