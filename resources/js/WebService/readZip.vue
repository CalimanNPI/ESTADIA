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
                    <h3 class="font-semibold text-lg text-gray-800">CFDI</h3>
                </div>
            </div>
        </div>
        <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            <form
                @submit.prevent="submit_from"
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
                            >Tipos de datos a procesar</span
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
                    <label
                        for="key"
                        class="text-sm font-medium text-gray-900 block mb-2"
                        >Archivo ZIP</label
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
                        @change="select_file"
                        required=""
                    />
                </div>
                <div class="mt-8 md:my-8">
                    <Button
                        color="blue"
                        iconName="question-circle"
                        :disabled="form_submitting"
                        :value="
                            form_submitting ? 'Consultando...' : 'Consultar'
                        "
                    />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import InputError from "../components/InputError.vue";
import Button from "../components/Button.vue";
import Label from "../components/Label.vue";
import RadioBox from "../components/Radio.vue";

export default {
    components: {
        InputError,
        Button,
        RadioBox,
        Label
    },
    data() {
        return {
            fields: {
                zip: null,
                download: ""
            },
            errors: {},
            form_submitting: false,
            todos: []
        };
    },
    mounted() {},
    methods: {
        select_file(event) {
            this.fields.zip = event.target.files[0];
        },
        async getProcesados() {
            await axios
                .get(
                    "/api/procesamiento/" +
                        this.$cookies.get("currentEmpresa") +
                        "/solicitudFiles/"
                )
                .then(response => {
                    this.todos = response.data;
                })
                .catch(err => {
                    this.form_submitting = false;
                    this.$swal({ icon: "error", title: response.data.error });
                    if (err.response.status === 422) {
                        this.errors = err.response.data.error;
                    }
                });
        },
        async submit_from() {
            let fields = new FormData();
        for (let i in this.fields) {
          fields.append(i, this.fields[i]);
        }
            await axios
                .get(
                    "/api/procesamiento/" +
                        this.$cookies.get("currentEmpresa") +
                        "/solicitudFiles/",fields
                )
                .then(response => {
                    this.todos = response.data;
                })
                .catch(err => {
                    this.form_submitting = false;
                    this.$swal({ icon: "error", title: response.data.error });
                    if (err.response.status === 422) {
                        this.errors = err.response.data.error;
                    }
                });
        }
    }
};
</script>

<style>
input[type="file"]::-webkit-file-upload-button,
input[type="file"]::file-selector-button {
    @apply text-white bg-blue-500 hover:bg-blue-700 font-medium text-sm cursor-pointer border-0 py-2.5 pl-8 pr-4;
    margin-inline-start: -1rem;
    margin-inline-end: 1rem;
}
</style>
