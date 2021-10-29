<template>
  <div class="container w-full md:w-4/5 xl:w-4/5 mx-auto px-2">
    <div id="recipients" class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
      <form class="w-full max-w-lg" @submit.prevent="submit_from">
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label
              class="
                block
                uppercase
                tracking-wide
                text-gray-700 text-xs
                font-bold
                mb-2
              "
              for="titulo"
            >
              Título
            </label>
            <input
              type="text"
              v-model="fields.titulo"
              id="titulo"
              name="titulo"
              require
              class="
                appearance-none
                block
                w-full
                bg-gray-200
                text-gray-700
                border border-gray-200
                rounded
                py-3
                px-4
                mb-3
                leading-tight
                focus:outline-none
                focus:bg-white
                focus:border-gray-500
              "
            />
            <p
              class="text-gray-600 text-xs italic"
              v-if="errors && errors.titulo"
            >
              {{ errors.titulo[0] }}
            </p>
          </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label
              class="
                block
                uppercase
                tracking-wide
                text-gray-700 text-xs
                font-bold
                mb-2
              "
              for="contenido"
            >
              Contenido
            </label>
            <input
              type="text"
              v-model="fields.contenido"
              id="contenido"
              name="contenido"
              require
              class="
                appearance-none
                block
                w-full
                bg-gray-200
                text-gray-700
                border border-gray-200
                rounded
                py-3
                px-4
                mb-3
                leading-tight
                focus:outline-none
                focus:bg-white
                focus:border-gray-500
              "
            />
            <p
              class="text-gray-600 text-xs italic"
              v-if="errors && errors.contenido"
            >
              {{ errors.contenido[0] }}
            </p>
          </div>
        </div>

        <input type="file" @change="select_file" />

        <input
          type="submit"
          class="
            shadow
            bg-purple-500
            hover:bg-purple-400
            focus:shadow-outline
            focus:outline-none
            text-white
            font-bold
            py-2
            px-4
            rounded
            transition duration-300 ease-in-out
          "
          :disabled="form_submitting"
          :value="form_submitting ? 'Saving blog ...' : 'Save'"
        />
      </form>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      fields: {
        titulo: "",
        contenido: "",
        archivo: null,
      },
      errors: {},
      form_submitting: false,
    };
  },
  mounted() {
    axios.get("/api/blogs/" + this.$route.params.id).then((response) => {
      this.fields = response.data.data;
    });
  },
  methods: {
    select_file(event) {
      this.fields.archivo = event.target.files[0];
    },
    submit_from() {
      this.form_submitting = true;

      axios
        .put("/api/blogs/" + this.$route.params.id, this.fields)
        .then((result) => {
          this.$router.push("/");
          this.form_submitting = false;
        })
        .catch((err) => {
          if (err.response.status === 422) {
            this.errors = err.response.data.errors;
          }
          this.form_submitting = false;
        });
    },
  },
};
</script>