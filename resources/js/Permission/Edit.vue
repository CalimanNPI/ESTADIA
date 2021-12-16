<template>
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
      iconName="font-awesome"
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
  mounted() {
    axios.get("/api/permission/" + this.$route.params.id).then((response) => {
      this.fields = response.data;
    });
  },
  methods: {
    submit_from() {
      this.form_submitting = true;
      axios
        .put("/api/permission/" + this.$route.params.id, this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "Se actualizo el permiso",
          });
          this.$router.push("/user");
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
