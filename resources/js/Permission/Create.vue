<template>
  <form @submit.prevent="submit_from">
    <div class="mb-6">
          <Label>Nombre</Label>
      <Input v-model="fields.name" placeholder="Ingrese el nombre del permiso"></Input>
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
