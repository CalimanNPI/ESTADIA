<template>
  <div class="md:container md:mx-auto">
    <form @submit.prevent="getConsultation" class="flex space-x-2 md:space-x-8">
      <fieldset
        class="
          flex-initial
          md:flex-1
          mt-8
          md:my-8
          rounded-r-lg
          border-solid border-2 border-blue-300
          hover:border-blue-700
          row-span-2
        "
      >
        <legend>
          <span class="text-blue-500 hover:underline text-center"
            >Tipos de datos</span
          >
        </legend>
        <RadioBox
          label="Emitidos"
          idbox="emitidos"
          value="emitidos"
          v-model="fields.data"
          nameRadio="data"
        />
        <RadioBox
          label="Recibidos"
          idbox="recibidos"
          value="recibidos"
          v-model="fields.data"
          nameRadio="data"
        />

        <input-error v-if="errors && errors.data" :message="errors.data[0]" />
      </fieldset>
      <fieldset
        class="
          flex-initial
          md:flex-1
          mt-8
          md:my-8
          rounded-r-lg
          border-solid border-2 border-blue-300
          hover:border-blue-700
          row-span-2
        "
      >
        <legend>
          <span class="text-blue-500 hover:underline text-center"
            >Tipos de datos a descargar</span
          >
        </legend>
        <RadioBox
          label="Metadata"
          idbox="metadata"
          value="metadata"
          v-model="fields.download"
          nameRadio="download"
        />
        <RadioBox
          label="CFDI"
          idbox="CFDI"
          value="CFDI"
          v-model="fields.download"
          nameRadio="download"
        />
        <input-error
          v-if="errors && errors.download"
          :message="errors.download[0]"
        />
      </fieldset>
      <div class="flex-initial md:flex-1 mt-8 md:my-8">
        <input-error v-if="errors && errors.start" :message="errors.start[0]" />
        <input-error v-if="errors && errors.end" :message="errors.end[0]" />
        <Label value="Fecha Solicitud" />
        <date-picker v-model="time" range valueType="format" />
      </div>
      <div class="flex-initial md:flex-1 mt-8 md:my-8">
        <Button
          color="blue"
          iconName="question-circle"
          :disabled="form_submitting"
          :value="form_submitting ? 'Consultando...' : 'Consultar'"
        />
      </div>
    </form>
<!--
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
    </div> -->

    <p>{{ time }} <button @click="hola()">Holi</button></p>
    <p>{{ fields }}</p>

    <div >{{ todos }}</div>
  </div>
</template>

<script>
import InputError from "../components/InputError.vue";
import Button from "../components/Button.vue";
import Label from "../components/Label.vue";
import RadioBox from "../components/Radio.vue";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  components: {
    InputError,
    Button,
    RadioBox,
    Label,
    DatePicker,
  },
  data() {
    return {
      fields: {
        start: "",
        end: "",
        data: "",
        download: "",
      },
      errors: {},
      form_submitting: false,
      todos: [],
      nextTodoId: 1,
      time: null,
    };
  },
  mounted() {},
  methods: {
    async getConsultation() {
        if(!$cookies.isKey("currentEmpresa")){
            throw this.$swal({
              icon: "error",
              title: 'Seleccione una empresa',
            });;
       }
      this.form_submitting = true;
      this.fields.start = this.time[0];
      this.fields.end = this.time[1];
      await axios
        .post(
          "/api/procesamiento/consultation/" +
            this.$cookies.get("currentEmpresa"),
          this.fields
        )
        .then((response) => {
          if (response.status == 200) {
            //this.$swal({ icon: "success", title: response.data.message });
            this.todos = response.data;
            // this.todos.push({
            //   id: this.nextTodoId++,
            //   title: response.data.message,
            //   requestId: response.data.requestId,
            //   packagesIds: "",
            //   link: "",
            //   start: this.fields.startdate,
            //   end: this.fields.enddate,
            //   data: this.fields.datatypes,
            //   types: this.fields.downloadtypes,
            //   pet: response.data.estadopet,
            //   sol: response.data.estadosol,
            // });
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
