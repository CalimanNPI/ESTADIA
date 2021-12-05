<template>
  <form @submit.prevent="submit_from">
    <div class="mb-6">
      <label for="nombre" class="text-sm font-medium text-gray-900 block mb-2"
        >Nombre</label
      >
      <input
        v-model="fields.nombre"
        id="nombre"
        require
        class="
          bg-gray-50
          border border-gray-300
          text-gray-900
          sm:text-sm
          rounded-lg
          focus:ring-blue-500
          focus:border-blue-500
          block
          w-full
          p-2.5
        "
      />
      <p
        class="mt-2 text-sm text-red-600 italic"
        v-if="errors && errors.nombre"
      >
        {{ errors.nombre[0] }}
      </p>
    </div>

    <div class="mb-6">
      <label
        for="razonsocial"
        class="text-sm font-medium text-gray-900 block mb-2"
        >Razón Social</label
      >
      <input
        type="text"
        v-model="fields.razonsocial"
        id="razonsocial"
        require
        class="
          bg-gray-50
          border border-gray-300
          text-gray-900
          sm:text-sm
          rounded-lg
          focus:ring-blue-500
          focus:border-blue-500
          block
          w-full
          p-2.5
        "
      />
      <p
        class="mt-2 text-sm text-red-600 italic"
        v-if="errors && errors.razonsocial"
      >
        {{ errors.razonsocial[0] }}
      </p>
    </div>

    <div class="mb-6">
      <label for="email" class="text-sm font-medium text-gray-900 block mb-2"
        >Clave CIEC</label
      >
      <input
        type="text"
        v-model="fields.claveciec"
        id="claveciec"
        require
        class="
          bg-gray-50
          border border-gray-300
          text-gray-900
          sm:text-sm
          rounded-lg
          focus:ring-blue-500
          focus:border-blue-500
          block
          w-full
          p-2.5
        "
      />
      <p
        class="mt-2 text-sm text-red-600 italic"
        v-if="errors && errors.claveciec"
      >
        {{ errors.claveciec[0] }}
      </p>
    </div>

    <div class="mb-6">
      <label
        for="razonsocial"
        class="text-sm font-medium text-gray-900 block mb-2"
        >RFC</label
      >
      <input
        type="text"
        v-model="fields.rfc"
        id="rfc"
        require
        class="
          bg-gray-50
          border border-gray-300
          text-gray-900
          sm:text-sm
          rounded-lg
          focus:ring-blue-500
          focus:border-blue-500
          block
          w-full
          p-2.5
        "
      />
      <p class="mt-2 text-sm text-red-600 italic" v-if="errors && errors.rfc">
        {{ errors.rfc[0] }}
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
        transition duration-300 ease-in-out
      "
    />
  </form>
</template>
<script>
export default {
  data() {
    return {
      fields: {
        nombre: "",
        rfc: "",
        razonsocial: "",
        claveciec: "",
      },
      errors: {},
      form_submitting: false,
    };
  },
  mounted() {
    axios.get("/api/empresa/" + this.$route.params.id).then((response) => {
      this.fields = response.data.data;
    });
  },
  methods: {
    submit_from() {
      this.form_submitting = true;
      axios
        .put("/api/empresa/" + this.$route.params.id, this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "La Empresa se actualizo",
          });
          this.$router.push("/empresa");
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
  },
};
</script>
