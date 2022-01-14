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
          <h3 class="font-semibold text-lg text-gray-800">Crear Empresa</h3>
        </div>
      </div>
    </div>
    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
      <form @submit.prevent="submit_from">
        <div class="mb-6">
          <Label>Nombre empresa</Label>
          <Input
            v-model="fields.nombre"
            placeholder="Ingrese el nombre de la empresa"
          ></Input>
          <input-error
            v-if="errors && errors.nombre"
            :message="errors.nombre[0]"
          ></input-error>
        </div>

        <div class="mb-6">
          <Label>Razón Social</Label>
          <Input
            v-model="fields.razonsocial"
            placeholder="Ingrese la razón social"
          ></Input>
          <input-error
            v-if="errors && errors.razonsocial"
            :message="errors.razonsocial[0]"
          ></input-error>
        </div>

        <div class="mb-6">
          <Label>Clave CIEC</Label>
          <Input
            v-model="fields.claveciec"
            placeholder="Ingrese la clave CIEC"
          ></Input>
          <input-error
            v-if="errors && errors.claveciec"
            :message="errors.claveciec[0]"
          ></input-error>
        </div>

        <div class="mb-6">
          <Label>RFC</Label>
          <Input v-model="fields.rfc" placeholder="Ingrese el RFC"></Input>
          <input-error
            v-if="errors && errors.rfc"
            :message="errors.rfc[0]"
          ></input-error>
        </div>

        <Button
          color="blue"
          iconName="plus-square"
          :disabled="form_submitting"
          :value="form_submitting ? 'Guardando...' : 'Guardar'"
        />
      </form>
    </div>
  </div>
</template>
<script>
import Input from "../components/Input.vue";
import InputError from "../components/InputError.vue";
import Button from "../components/Button.vue";
import Label from "../components/Label.vue";

export default {
  components: { InputError, Input, Button, Label },
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
  methods: {
    submit_from() {
      this.form_submitting = true;
      axios
        .post("/api/empresa", this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "Se creó el rol correctamente",
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
