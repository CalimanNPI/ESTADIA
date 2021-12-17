<template>
  <form @submit.prevent="submit_from">
    <div class="mb-6">
      <Label>Nombre</Label>
      <Input v-model="fields.name" placeholder="Carlos J ..."></Input>
      <input-error
        v-if="errors && errors.name"
        :message="errors.name[0]"
      ></input-error>
    </div>

    <div class="mb-6">
      <Label>Email</Label>
      <Input v-model="fields.email" placeholder="Email ..."></Input>
      <input-error
        v-if="errors && errors.email"
        :message="errors.email[0]"
      ></input-error>
    </div>

    <div class="mb-6">
      <Label>Password</Label>
      <Input v-model="fields.password" placeholder="password"></Input>
      <input-error
        v-if="errors && errors.password"
        :message="errors.password[0]"
      ></input-error>
    </div>

    <div class="mb-6">
      <Label>Password confirmation</Label>
      <Input
        v-model="fields.password_confirmation"
        placeholder="Confirme el password"
      ></Input>
      <input-error
        v-if="errors && errors.password_confirmation"
        :message="errors.password_confirmation[0]"
      ></input-error>
    </div>
    <div class="mb-6">
      <label for="rol" class="text-sm font-medium text-gray-900 block mb-2"
        >Seleccione el rol</label
      >
      <select
        id="rol"
        class="
          bg-gray-50
          border border-gray-300
          text-gray-900
          sm:text-sm
          rounded-lg
          focus:ring-blue-500 focus:border-blue-500
          block
          w-full
          p-2.5
        "
        v-model="fields.roles"
      >
         <option disabled value="">Seleccione un elemento</option>
        <option v-for="item in items" :key="item.id" :value="item.id">
          {{ item.name }}
        </option>
      </select>
      <p class="mt-2 text-sm text-red-600 italic" v-if="errors && errors.roles">
        {{ errors.roles[0] }}
      </p>
    </div>

     <Button
      color="blue"
      iconName="edit"
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
        email: "",
        password: "",
        password_confirmation: "",
        roles: [],
      },
      items: [],
      errors: {},
      form_submitting: false,
    };
  },
  mounted() {
    this.getResults();
    axios.get("/api/user/" + this.$route.params.id).then((response) => {
      this.fields = response.data;
    });
  },
  methods: {
    submit_from() {
      this.form_submitting = true;
      axios
        .put("/api/user/" + this.$route.params.id, this.fields)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "Se actualizó el rol correctamente",
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
    getResults() {
      axios
        .get("/api/role")
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
