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

    <div class="mb-6">
      <label for="email" class="text-sm font-medium text-gray-900 block mb-2"
        >Email</label
      >
      <input
        type="email"
        v-model="fields.email"
        id="email"
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
      <p class="mt-2 text-sm text-red-600 italic" v-if="errors && errors.email">
        {{ errors.email[0] }}
      </p>
    </div>

    <div class="mb-6">
      <label for="password" class="text-sm font-medium text-gray-900 block mb-2"
        >Password</label
      >
      <input
        type="password"
        v-model="fields.password"
        id="password"
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
      <p
        class="mt-2 text-sm text-red-600 italic"
        v-if="errors && errors.password"
      >
        {{ errors.password[0] }}
      </p>
    </div>

    <div class="mb-6">
      <label
        for="password_confirmation"
        class="text-sm font-medium text-gray-900 block mb-2"
        >Password confirmation</label
      >
      <input
        type="password"
        v-model="fields.password_confirmation"
        id="password_confirmation"
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
      <p
        class="mt-2 text-sm text-red-600 italic"
        v-if="errors && errors.password_confirmation"
      >
        {{ errors.password_confirmation[0] }}
      </p>
    </div>
    <div class="mb-6">
      <label
        for="rol"
        class="text-sm font-medium text-gray-900 block mb-2"
        >Seleccione el rol</label
      >
      <select
        id="rol"
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
        v-model="fields.roles"
      >
        <option v-for="item in items" :key="item.id" :value="item.id">{{item.name}}</option>
      </select>
        <p
        class="mt-2 text-sm text-red-600 italic"
        v-if="errors && errors.roles"
      >
        {{ errors.roles[0] }}
      </p>
    </div>

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
        email: "",
        password: "",
        password_confirmation: "",
        roles:""
      },
      items: [],
      errors: {},
      form_submitting: false,
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    submit_from() {
      this.form_submitting = true;
      axios
        .post("/api/user", this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "El usuario se creo",
          });
          this.$router.push("/user");
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
  },
};
</script>
