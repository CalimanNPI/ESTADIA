<template>
  <div class="md:container md:mx-auto">
    <form @submit.prevent="getConsultation">
      <div class="grid grid-cols-6 gap-4">
        <div class="col-start-2 col-span-4 mb-6 flex">
          <div class="grow h-14">
            <input
              name="start"
              type="date"
              v-model="fields.start"
              class="
                shadow-sm
                bg-gray-50
                border border-blue-200
                md:border-blue-200
                focus:border-blue-500
                border-opacity-75
                text-gray-900
                sm:text-sm
                rounded-lg
                block
                w-full
                p-2.5
                placeholder-gray-500
              "
            />
            <input-error
              v-if="errors && errors.start"
              :message="errors.start[0]"
            ></input-error>
          </div>
          <div class="grow-0 h-14 text-lg font-bold a">Rango de fechas</div>
          <div class="grow h-14">
            <input
              name="end"
              type="date"
              v-model="fields.end"
              class="
                shadow-sm
                bg-gray-50
                border border-blue-200
                md:border-blue-200
                focus:border-blue-500
                border-opacity-75
                text-gray-900
                sm:text-sm
                rounded-lg
                block
                w-full
                p-2.5
                placeholder-gray-500
              "
            />
            <input-error
              v-if="errors && errors.end"
              :message="errors.end[0]"
            ></input-error>
          </div>
        </div>
        <div class="col-start-1 col-end-3 mb-6">
          <fieldset
            class="
              rounded-r-lg
              border-solid border-2 border-blue-300
              hover:border-blue-700
              row-span-2
            "
          >
            <legend>
              <span class="text-gray-900 text-center">Tipos de datos</span>
            </legend>

            <div class="flex items-center mb-4">
              <Radio
                label="emitidos"
                idcheckbox="Emitidos"
                value="emitidos"
                v-model="fields.data"
                nameRadio="data"
              />
              <Radio
                label="recibidos"
                idcheckbox="Recibidos"
                value="recibidos"
                v-model="fields.data"
                nameRadio="data"
              />
              <input-error
                v-if="errors && errors.data"
                :message="errors.data[0]"
              ></input-error>
            </div>
          </fieldset>
        </div>
        <div class="col-end-7 col-span-2 mb-6">
          <fieldset
            class="
              rounded-r-lg
              border-solid border-2 border-blue-300
              hover:border-blue-700
              row-span-2
            "
          >
            <legend>
              <span class="text-gray-900 text-center"
                >Tipos de datos a descargar</span
              >
            </legend>

            <div class="flex items-center mb-4">
              <Radio
                label="Metadata"
                idcheckbox="metadata"
                value="metadata"
                v-model="fields.download"
                nameRadio="download"
              />
              <Radio
                label="CFDI"
                idcheckbox="CFDI"
                value="CFDI"
                v-model="fields.download"
                nameRadio="download"
              />
              <input-error
                v-if="errors && errors.download"
                :message="errors.download[0]"
              ></input-error>
            </div>
          </fieldset>
        </div>
        <div class="col-start-1 col-end-7 mb-6">
          <Button
            color="blue"
            iconName="question-circle"
            :disabled="form_submitting"
            :value="form_submitting ? 'Consultando...' : 'Consultar'"
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

    <RadioBox label="Baz" value="baz" v-model="MySelectedValue" />
    <RadioBox label="Baz" value="baz" v-model="MySelectedValue" />
    <RadioBox label="Baz" value="baz" v-model="MySelectedValue" />
  </div>
</template>

<script>
import InputError from "../components/InputError.vue";
import Button from "../components/Button.vue";
import RadioBox from "../components/Radio.vue";

export default {
  components: {
    InputError,
    Button,
    Label,
    RadioBox,
  },
  data() {
    return {
      fields: {
        start: "",
        end: "",
        data: "",
        download: "",
      },
      MySelectedValue: "",
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
      console.log(this.MySelectedValue);
      this.form_submitting = true;
      await axios
        .post(
          "/api/procesamiento/consultation/" +
            this.$cookies.get("currentEmpresa"),
          this.fields
        )
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
          this.form_submitting = false;
          this.$swal({ icon: "error", title: response.data.error, tem });
          if (err.response.status === 422) {
            this.errors = err.response.data.error;
          }
        });
    },
    async getVerification(id) {
      await axios
        .post(
          `api/procesamiento/${this.$cookies.get(
            "currentEmpresa"
          )}/verification/${id}`
        )
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
          this.form_submitting = false;
          this.$swal({ icon: "error", title: "Error" + response.data.error });
          if (err.response.status === 422) {
            this.errors = err.response.data.error;
          }
        });
    },
    async getDownloadLink(id) {
      // window.open(`api/procesamiento/downloadLink/${id}`);
      await axios
        .post("api/procesamiento/downloadLink/" + id, this.$currentEmpresa)
        .then((response) => {
          var fileUrl = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");
          fileLink.href = fileUrl;
          fileLink.setAttribute("download", "archivo1.zip");
          document.body.appendChild(fileLink);
          fileLink.click();
        })
        .catch((err) => {
          this.$swal({ icon: "error", title: "Error" + response.data.error });
          if (err.response.status === 422) {
            this.errors = err.response.data.errors;
          }
          this.form_submitting = false;
        });
    },
  },
};
</script>
