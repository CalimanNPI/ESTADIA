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
          <h3 class="font-semibold text-lg text-gray-800">Descarga CFDI</h3>
        </div>
      </div>
    </div>
    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
      <form
        @submit.prevent="getConsultation"
        class="flex flex-col md:flex-row space-x-2 md:space-x-8"
      >
        <fieldset
          class="
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
        <div class="mt-8 md:my-8">
          <input-error
            v-if="errors && errors.start"
            :message="errors.start[0]"
          />
          <input-error v-if="errors && errors.end" :message="errors.end[0]" />
          <Label value="Fecha Solicitud" />
          <date-picker v-model="time" range valueType="format" />
          <!-- Toggle -->

          <label for="toogleA" class="flex items-center cursor-pointer">
            <!-- toggle -->
            <div class="relative">
              <!-- input -->
              <input
                id="toogleA"
                type="checkbox"
                class="sr-only"
                v-model="pendientes"
                @change="getProcesados()"
              />
              <!-- line -->
              <div class="w-10 h-4 bg-gray-300 rounded-full shadow-inner"></div>
              <!-- dot -->
              <div
                class="
                  dot
                  absolute
                  w-6
                  h-6
                  bg-white
                  rounded-full
                  shadow
                  -left-1
                  -top-1
                  transition
                "
              ></div>
            </div>
            <!-- label -->
            <div class="ml-3 text-gray-700 font-medium">
              Solo descargar pendientes.
            </div>
          </label>
        </div>
        <div class="mt-8 md:my-8">
          <Button
            color="blue"
            iconName="question-circle"
            :disabled="form_submitting"
            :value="form_submitting ? 'Consultando...' : 'Consultar'"
          />
        </div>
      </form>

      <Alert v-if="message!=null">{{message}}</Alert>

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
                      v-for="headTable in headTables"
                    >
                      {{ headTable }}
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
                    v-bind:key="todo.idsolicitud"
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
                      {{ todo.idpet }}
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
                      {{ todo.tipo }}
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
                      {{ todo.tipo_archivos }}
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
                      {{ todo.fechaini }}
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
                      {{ todo.fechafin }}
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
                      {{ todo.fechasol }}
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
                      {{ todo.estadopet }}
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
                      {{ todo.estadosol }}
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
                      v-if="todo.estadosol == 'En proceso'"
                    >
                      <Button
                        color="green"
                        iconName="question-circle"
                        :disabled="form_submitting"
                        :value="
                          form_submitting ? 'Actualizando...' : 'Actualizar'
                        "
                        @click.native="getVerification(todo.idpet)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import InputError from "../components/InputError.vue";
import Button from "../components/Button.vue";
import Alert from "../components/Alert.vue";
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
    Alert
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
      headTables: [
        "Solicitud",
        "Tipo",
        "Tipo Archivo",
        "Fecha inicio",
        "Fecha Final",
        "Fecha Petición",
        "Estado Petición",
        "Estado solicitud",
      ],
      pendientes: null,
      message: null,
    };
  },
  mounted() {},
  methods: {
    async getConsultation() {
      if (!$cookies.isKey("currentEmpresa")) {
        this.$swal({
          icon: "error",
          title: "Seleccione una empresa",
        });
      } else {
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
              this.todos = response.data;
            }
            if (response.data.cod == 400) {
              this.$swal({ icon: "error", title: response.data.message });
            }
            this.form_submitting = false;
          })
          .catch((err) => {
            this.form_submitting = false;
            this.$swal({ icon: "error", title: response.data.error });
            if (err.response.status === 422) {
              this.errors = err.response.data.error;
            }
          });
      }
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
              this.message =  response.data.message;
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
    async getProcesados() {
      await axios
        .get(
          "/api/procesamiento/" +
            this.$cookies.get("currentEmpresa") +
            "/solicitud/" +
            this.pendientes
        )
        .then((response) => {
             this.todos = response.data;
        })
        .catch((err) => {
          this.form_submitting = false;
          this.$swal({ icon: "error", title: response.data.error });
          if (err.response.status === 422) {
            this.errors = err.response.data.error;
          }
        });
    },
  },
};
</script>

<style>
/* Toggle */
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: #2563eb;
}
</style>
