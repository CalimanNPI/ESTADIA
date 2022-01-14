<template>
  <div
    class="
      relative
      flex flex-col
      min-w-0
      break-words
      w-full
      mb-6
      shadow-sm
      rounded
      bg-white
      sm:rounded-lg
    "
  >
    <div class="rounded-t mb-0 px-4 py-3 border-b border-gray-200">
      <div class="flex flex-wrap items-center">
        <div
          class="
            relative
            w-full
            px-4
            max-w-full
            flex-grow flex-1 flex
            justify-between
          "
        >
          <h3 class="font-semibold text-lg text-gray-800">Roles</h3>
          <Link
            color="blue"
            iconName="plus-square"
            value="Crear rol"
            :link="{ name: 'role.create' }"
          />
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto border-b border-gray-200">
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
                        px-6
                        py-3
                        text-xs
                        font-medium
                        tracking-wider
                        text-left text-gray-700
                        uppercase
                        dark:text-gray-400
                      "
                    >
                      Nombre
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-xs
                        font-medium
                        tracking-wider
                        text-left text-gray-700
                        uppercase
                        dark:text-gray-400
                      "
                    >
                      Guard
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-xs
                        font-medium
                        tracking-wider
                        text-left text-gray-700
                        uppercase
                        dark:text-gray-400
                      "
                    >
                      Permisos
                    </th>
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
                      class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
                    >
                      {{ item.name }}
                    </td>
                    <td
                      class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
                    >
                      {{ item.guard_name }}
                    </td>
                    <td
                      class="
                        px-6
                        py-4
                        text-sm text-gray-500
                        whitespace-nowrap
                        flex flex-wrap
                      "
                    >
                      <Badge
                        v-for="permission in item.permissions"
                        :key="permission.id"
                        :value="permission.name"
                      />
                    </td>

                    <td
                      class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
                    >
                      <Link
                        color="blue"
                        iconName="edit"
                        value="Editar"
                        :link="{ name: 'role.edit', params: { id: item.id } }"
                      />

                      <Button
                        color="red"
                        iconName="trash-alt"
                        value="Eliminar"
                        v-on:click.native="delete_role(item.id)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <tailable-pagination :data="items" :showNumbers="true" />
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
      items: {},
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios
        .get("/api/role")
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
    delete_role(id) {
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
            .delete("/api/role/" + id)
            .then((result) => {
              this.$swal({
                icon: "sucess",
                title: "Delete successfully",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK",
              });
              this.getResults();
            })
            .catch((err) => {
              this.$swal({
                icon: "error",
                title: "Error Happened",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK",
              });
            });
        }
      });
    },
  },
};
</script>
