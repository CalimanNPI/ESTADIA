<template>
  <form @submit.prevent="submit_from">
    <div class="mb-6">
      <Label>Nombre Rol</Label>
      <Input
        v-model="fields.name"
        placeholder="Ingrese el nombre del Rol"
      ></Input>
      <input-error
        v-if="errors && errors.name"
        :message="errors.name[0]"
      ></input-error>
    </div>

    <fieldset>
      <legend>Permisos</legend>
        <div class="flex items-center items-start mb-4">
              <Checkbox
          v-for="item in items"
          :key="item.id"
          :label="item.name"
          :idcheckbox="item.name"
          :value="item.id"
          v-model="fields.permissions"
        />
      </div>
    </fieldset>
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
        permissions: [],
      },
      errors: {},
      form_submitting: false,
      items: [],
    };
  },
  mounted() {
    this.getResults();
    axios.get("/api/role/" + this.$route.params.id).then((response) => {
      this.fields = response.data;
    });
  },
  methods: {
    submit_from() {
      console.log("the fields  " + this.fields);
      this.form_submitting = true;
      axios
        .put("/api/role/" + this.$route.params.id, this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "El rol se actualizo",
          });
          this.$router.push("/role");
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
    getResults() {
      axios
        .get("/api/permission")
        .then((response) => {
          this.items = response.data;
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Se produjo un Error",
            text: "error en : " + err,
          });
        });
    },
  },
};
</script>
