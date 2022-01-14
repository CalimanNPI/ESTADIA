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
            flex-grow flex-1
            justify-between
          "
        >
          <h3 class="font-semibold text-lg text-gray-800">Editar Rol</h3>
        </div>
      </div>
    </div>
    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
      <form @submit.prevent="submit_from">
        <div class="mb-6">
          <Label>Nombre Rol</Label>
          <Input
            v-model="fields.name"
            placeholder="Ingrese el nombre del Rol"
          ></Input>
          <input-error
            v-if="errors && errors.name"
            :message="errors.name[0]"
          ></input-error>
        </div>

        <div class="mb-6">
          <label
            for="permissions"
            class="
              block
              mb-2
              text-sm
              font-medium
              text-gray-900
              dark:text-gray-400
            "
            >Seleccione los permisos</label
          >
          <select
            id="permissions"
            v-model="permission"
            @change="selectPermission()"
            class="
              bg-gray-50
              border border-gray-300
              text-gray-900 text-sm
              rounded-lg
              focus:ring-blue-500 focus:border-blue-500
              block
              w-full
              p-2.5
              dark:bg-gray-700
              dark:border-gray-600
              dark:placeholder-gray-400
              dark:text-white
              dark:focus:ring-blue-500
              dark:focus:border-blue-500
            "
          >
            <option disabled value="">Seleccione un elemento</option>
            <option
              v-for="item in items"
              :key="item.id"
              v-bind:value="{ id: item.id, name: item.name }"
            >
              {{ item.name }}
            </option>
          </select>
        </div>
        <fieldset
          class="
            rounded-r-lg
            border-solid border-2 border-blue-300
            hover:border-blue-700
            row-span-2
          "
        >
          <legend>
            <span class="text-gray-900 text-center">Permisos</span>
          </legend>
          <div class="mb-6 px-6 py-4 text-sm whitespace-nowrap flex flex-wrap">
            <span
              class="
                bg-blue-100
                text-blue-800 text-xs
                font-semibold
                mr-2
                px-2.5
                py-0.5
                rounded
                dark:bg-blue-200 dark:text-blue-800
                cursor-pointer
                hover:bg-blue-400
              "
              v-for="perm in perms"
              :key="perm.id"
              @click="deletePermission(perm.id)"
              >{{ perm.name }} <font-awesome-icon :icon="['fas', 'times']"
            /></span>
          </div>
        </fieldset>
        <Button
          color="blue"
          iconName="edit"
          :disabled="form_submitting"
          :value="form_submitting ? 'Guardando...' : 'Guardar'"
        />
      </form>
    </div>
  </div>
</template>
<script>
import Input from "../components/Input.vue";
import InputError from "../components/InputError.vue";
import Button from "../components/Button.vue";
import Label from "../components/Label.vue";
export default {
  components: { InputError, Input, Button, Label },
  data() {
    return {
      fields: {
        name: "",
        permissions: [],
      },
      errors: {},
      form_submitting: false,
      items: [],
      permission: [],
      perms: [], //permisos
      filter: [],
    };
  },
  mounted() {
    this.getResults();
    this.getPermissions();
  },
  methods: {
    submit_from() {
      this.form_submitting = true;

      this.fields.permissions = this.perms.map(function (perm) {
        return perm.id;
      });

      axios
        .put("/api/role/" + this.$route.params.id, this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "Se actualizó el rol correctamente",
          });
          this.$router.push("/role");
          this.form_submitting = false;
        })
        .catch((err) => {
          this.$swal({ icon: "error", title: "Error" + err });
          if (err.response.status === 422) {
            this.errors = err.response.data.errors;
          }
          this.form_submitting = false;
        });
    },
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
    selectPermission() {
      this.filterResults();
      if (this.filter.length == 0) {
        this.perms.push(this.permission);
      }
      this.filter.pop();
    },
    filterResults() {
      this.filter = this.perms.filter((perm) =>
        perm.name.toLowerCase().startsWith(this.permission.name.toLowerCase())
      );
    },
    deletePermission(id) {
      this.perms.forEach(function (perm, index, object) {
        if (perm.id === id) {
          object.splice(index, 1);
        }
      });
    },
    getPermissions() {
      axios.get("/api/role/" + this.$route.params.id).then((response) => {
        this.fields.name = response.data.name;
        this.perms = response.data.permissions.map(function (value) {
          return { name: value.name, id: value.id };
        });
      });
    },
  },
};
</script>
