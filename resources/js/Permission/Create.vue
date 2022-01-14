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
          <h3 class="font-semibold text-lg text-gray-800">Crear Permiso</h3>
        </div>
      </div>
    </div>
    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
      <form @submit.prevent="submit_from">
        <div class="mb-6">
          <Label>Nombre</Label>
          <Input
            v-model="fields.name"
            placeholder="Ingrese el nombre del permiso"
          ></Input>
          <input-error
            v-if="errors && errors.name"
            :message="errors.name[0]"
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
        name: "",
      },
      errors: {},
      form_submitting: false,
    };
  },
  methods: {
    submit_from() {
      this.form_submitting = true;
      axios
        .post("/api/permission", this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "Se creó el rol correctamente",
          });
          this.$router.push("/permission");
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
