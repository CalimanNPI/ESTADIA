<template>
  <div class="md:container md:mx-auto">
    <form @submit.prevent="getConsultation">
      <div class="grid grid-cols-3 gap-4">
        <div class="col-span-3">
          <div class="flex items-center">
            <div class="relative">
              <input
                name="start"
                type="date"
                v-model="fields.startdate"
                class="
                  bg-gray-50
                  border border-gray-300
                  text-gray-900
                  sm:text-sm
                  rounded-lg
                  focus:ring-blue-500 focus:border-blue-500
                  block
                  w-full
                  pl-10
                  p-2.5
                "
              />
              <p
                class="mt-2 text-sm text-red-600 italic"
                v-if="errors && errors.startdate"
              >
                {{ errors.startdate[0] }}
              </p>
            </div>
            <span class="mx-4 text-gray-500">A</span>
            <div class="relative">
              <input
                name="end"
                type="date"
                v-model="fields.enddate"
                class="
                  bg-gray-50
                  border border-gray-300
                  text-gray-900
                  sm:text-sm
                  rounded-lg
                  focus:ring-blue-500 focus:border-blue-500
                  block
                  w-full
                  pl-10
                  p-2.5
                "
              />
              <p
                class="mt-2 text-sm text-red-600 italic"
                v-if="errors && errors.enddate"
              >
                {{ errors.enddate[0] }}
              </p>
            </div>
          </div>
        </div>
        <div>
          <fieldset class="border-dashed border-4 border-blue-500">
            <legend>
              <span
                class="
                  decoration-clone
                  bg-gradient-to-b
                  from-blue-200
                  to-blue-500
                  text-gray-900
                "
                >Tipos de datos</span
              >
            </legend>

            <div class="flex items-center mb-4">
              <input
                id="recibidos"
                name="datatypes"
                type="radio"
                value="recibidos"
                v-model="fields.datatypes"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                aria-labelledby="country-option-1"
                aria-describedby="country-option-1"
              />
              <label
                for="recibidos"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Recibidos
              </label>
            </div>

            <div class="flex items-center mb-4">
              <input
                id="emitidos"
                name="datatypes"
                type="radio"
                value="emitidos"
                v-model="fields.datatypes"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                aria-labelledby="country-option-2"
                aria-describedby="country-option-2"
              />
              <label
                for="emitidos"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Emitidos
              </label>
            </div>

            <p
              class="mt-2 text-sm text-red-600 italic"
              v-if="errors && errors.datatypes"
            >
              {{ errors.datatypes[0] }}
            </p>
          </fieldset>
        </div>
        <div>
          <fieldset class="border-dashed border-4 border-blue-500">
            <legend>
              <span
                class="
                  decoration-clone
                  bg-gradient-to-b
                  from-blue-200
                  to-blue-500
                  text-gray-900
                "
                >Tipo de Descarga</span
              >
            </legend>

            <div class="flex items-center mb-4">
              <input
                id="CFDI"
                name="downloadtypes"
                type="radio"
                value="CFDI"
                v-model="fields.downloadtypes"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                aria-labelledby="country-option-1"
                aria-describedby="country-option-1"
                checked=""
              />
              <label
                for="CFDI"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                CFDI
              </label>
            </div>

            <div class="flex items-center mb-4">
              <input
                id="metadata"
                name="downloadTypes"
                type="radio"
                value="metadata"
                v-model="fields.downloadtypes"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                aria-labelledby="country-option-2"
                aria-describedby="country-option-2"
              />
              <label
                for="metadata"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Metadata
              </label>
            </div>
            <p
              class="mt-2 text-sm text-red-600 italic"
              v-if="errors && errors.downloadtypes"
            >
              {{ errors.downloadtypes[0] }}
            </p>
          </fieldset>
        </div>
        <div>
          <input
            type="submit"
            :disabled="form_submitting"
            :value="form_submitting ? 'Consultando...' : 'Consultar'"
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
              duration-150
              ease-in-out
            "
          />
        </div>
      </div>
    </form>

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
                    Solicitud
                  </th>
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
                    Tipo
                  </th>
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
                    Tipo Archivo
                  </th>
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
                    Fecha inicio
                  </th>
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
                    Fecha Final
                  </th>
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
                    Estado Petición
                  </th>
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
                    Estado Solicitud
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Verificar</span>
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Descargar</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- Product 1 -->
                <tr
                  class="bg-white border-b"
                  v-for="todo in todos"
                  v-bind:key="todo.id"
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
                    {{ todo.requestId }}
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
                    {{ todo.data }}
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
                    {{ todo.types }}
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
                    {{ todo.start }}
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
                    {{ todo.end }}
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
                    {{ todo.pet }}
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
                    {{ todo.sol }}
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
                    <button
                      class="
                        text-white
                        bg-green-300
                        hover:bg-green-400
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
                      @click="getVerification(todo.requestId)"
                    >
                      Verificar
                    </button>
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
                    <button
                      class="
                        text-white
                        bg-green-700
                        hover:bg-green-800
                        focus:ring-4 focus:ring-blue-300
                        font-medium
                        rounded-lg
                        text-sm
                        px-5
                        py-2.5
                        items-center
                        transition
                        duration-300
                        ease-in-out
                      "
                      @click="getDownloadLink(todo.packagesIds)"
                    >
                      <span>Paquetes</span>
                    </button>
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
                    <a
                      class="
                        text-white
                        bg-green-700
                        hover:bg-green-800
                        focus:ring-4 focus:ring-blue-300
                        font-medium
                        rounded-lg
                        text-sm
                        px-5
                        py-2.5
                        items-center
                        transition
                        duration-300
                        ease-in-out
                      "
                      :href="todo.link"
                      download
                      target="_blank"
                    >
                      <span>Download</span>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fields: {
        startdate: "",
        enddate: "",
        datatypes: "",
        downloadtypes: "",
      },
      errors: {},
      form_submitting: false,
      todos: [],
      nextTodoId: 1,
    };
  },
  components: {},
  mounted() {},
  methods: {
    async getConsultation() {
      this.form_submitting = true;
      await axios
        .post("/api/procesamiento/consultation", this.fields)
        .then((response) => {
          if (response.status == 200) {
            this.$swal({ icon: "success", title: response.data.message });
            this.todos.push({
              id: this.nextTodoId++,
              title: response.data.message,
              requestId: response.data.requestId,
              packagesIds: "",
              link: "",
              start: this.fields.startdate,
              end: this.fields.enddate,
              data: this.fields.datatypes,
              types: this.fields.downloadtypes,
              pet: response.data.estadopet,
              sol: response.data.estadosol,
            });
          }
          if (response.data.cod == 400) {
            this.$swal({ icon: "error", title: response.data.message });
          }
          this.form_submitting = false;
        })
        .catch((err) => {
          this.$swal({ icon: "error", title: response.data.error });
          if (err.response.status === 422) {
            this.errors = err.response.data.errors;
          }
          this.form_submitting = false;
        });
    },
    async getVerification(id) {
      await axios
        .post("api/procesamiento/verification/" + id)
        .then((response) => {
          if (response.status == 200) {
            this.$swal({
              icon: "success",
              title: response.data.message,
              text: response.data.packages,
            });
            for (var i = 0; i < this.todos.length; i++) {
              if (this.todos[i].requestId == response.data.requestId) {
                this.todos[i].packagesIds = response.data.packagesIds;
              }
            }
          }
          if (response.data.cod == 400) {
            this.$swal({ icon: "error", title: response.data.message });
          }
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
    async getDownloadLink(id) {
      // window.open(`api/procesamiento/downloadLink/${id}`);
      await axios({
        url: "api/procesamiento/downloadLink/" + id,
        method: "GET",
        responseType: "blob",
      })
        .then((response) => {
          var fileUrl = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");
          fileLink.href = fileUrl;
          fileLink.setAttribute("download", "archivo1.zip");
          document.body.appendChild(fileLink);
          fileLink.click();
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
