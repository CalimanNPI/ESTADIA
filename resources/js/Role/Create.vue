<template>
  <form @submit.prevent="submit_from">
    <div class="mb-6">
      <label for="name" class="text-sm font-medium text-gray-900 block mb-2"
        >Nombre</label
      >
      <input
        v-model="fields.name"
        id="name"
        require
        class="
          bg-gray-50
          border border-gray-300
          text-gray-900
          sm:text-sm
          rounded-lg
          focus:ring-blue-500 focus:border-blue-500
          block
          w-full
          p-2.5
        "
      />
      <p class="mt-2 text-sm text-red-600 italic" v-if="errors && errors.name">
        {{ errors.name[0] }}
      </p>
    </div>
    <fieldset>
      <legend>Permisos</legend>
      <div v-for="item in items" :key="item.id">
        <div class="flex items-center items-start mb-4">
          <input
            :id="item.name"
            aria-describedby="checkbox-1"
            type="checkbox"
            class="
              bg-gray-50
              border-gray-300
              focus:ring-3 focus:ring-blue-300
              h-4
              w-4
              rounded
            "
            :value="item.id"
            v-model="fields.permissions"
            :name="item.name"
          />
          <label :for="item.name" class="text-sm ml-3 font-medium text-gray-900"
            >{{item.name}}
            </label
          >
        </div>
      </div>
    </fieldset>

    <input
      type="submit"
      :disabled="form_submitting"
      :value="form_submitting ? 'Guardando...' : 'Guardar'"
      class="
        text-white
        bg-blue-700
        hover:bg-blue-800
        focus:ring-4 focus:ring-blue-300
        font-medium
        rounded-lg
        text-sm
        px-5
        py-2.5
        text-center
        transition
        duration-300
        ease-in-out
      "
    />
  </form>
</template>
<script>
export default {
  data() {
    return {
      fields: {
        name: "",
        permissions:[]
      },
      errors: {},
      form_submitting: false,
      items: [],
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    submit_from() {
        console.log(this.fields);
      this.form_submitting = true;
      axios
        .post("/api/role", this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "El rol se creo",
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
  },
};
</script>
