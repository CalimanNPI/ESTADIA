<template>
  <form @submit.prevent="submit_from">
    <div class="mb-6">
      <label for="password" class="text-sm font-medium text-gray-900 block mb-2"
        >Contraseña</label
      >
      <input
        type="text"
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
      <div class="relative">
      <label for="cer" class="text-sm font-medium text-gray-900 block mb-2"
        >Archivo CER</label
      >
      <input
        type="file"
        id="cer"
        class="
          block
          w-full
          overflow-hidden
          cursor-pointer
          bg-gray-50
          border border-gray-300
          text-gray-900
          focus:outline-none
          focus:ring-2
          focus:ring-blue-500
          focus:border-transparent
          sm:text-sm
          rounded-lg
          block
          w-full
        "
        aria-describedby="user_avatar_help"
        @change="select_file_cer"
        required=""
      />
      </div>
    </div>

    <div class="mb-6">
      <div class="relative">
      <label for="key" class="text-sm font-medium text-gray-900 block mb-2"
        >Archivo KEY</label
      >
      <input
        type="file"
        id="key"
        class="
          block
          w-full
          overflow-hidden
          cursor-pointer
          bg-gray-50
          border border-gray-300
          text-gray-900
          focus:outline-none
          focus:ring-2
          focus:ring-blue-500
          focus:border-transparent
          sm:text-sm
          rounded-lg
          block
          w-full
        "
        aria-describedby="user_avatar_help"
        @change="select_file_key"
        required=""
      />

      </div>
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
        password: "",
        cer: null,
        key: null,
      },
      errors: {},
      form_submitting: false,
    };
  },
  methods: {
    select_file_cer(event) {
      this.fields.cer = event.target.files[0];
    },
    select_file_key(event) {
      this.fields.key = event.target.files[0];
    },
    submit_from() {
      this.form_submitting = true;

      let fields = new FormData();
      for (let i in this.fields) {
        fields.append(i, this.fields[i]);
      }

      axios
        .post("/api/empresa/fiel/" + this.$route.params.id, fields)
        .then((response) => {
          if (response.status == 200) {
            this.$swal({
              icon: "success",
              title: response.data.message,
              text: response.data.fiel,
            });
          }

          this.form_submitting = false;
          this.$router.push("/empresa");
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
<style>
input[type="file"]::-webkit-file-upload-button,
input[type="file"]::file-selector-button {
  @apply text-white bg-gray-700 hover:bg-gray-600 font-medium text-sm cursor-pointer border-0 py-2.5 pl-8 pr-4;
  margin-inline-start: -1rem;
  margin-inline-end: 1rem;
}
</style>
