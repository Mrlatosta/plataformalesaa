<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email</label>
        <input type="text" name="email" v-model="form.email" />
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" name="password" v-model="form.password" />
      </div>
      <div>
        <button type="submit">Iniciar sesión</button>
      </div>

      <p v-if="errors.length > 0" style="color:red" v-for="(err, k) in errors" :key="k">{{ err }}</p>
    </form>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
import axios from "axios";

export default {
  data: () => ({
    form: {
      email: "",
      password: "",
    },
    errors: [],
  }),
  methods: {
    login() {
      this.errors = [];
      if (!this.form.email || !this.form.password) {
        this.errors = ["Todos los campos son requeridos."];
        return;
      }

      axios
        .post("login", {
          email: this.form.email,
          password: this.form.password,
        })
        .then(() => {
          router.get("inicio");
        })
        .catch((err) => {
          if (err.response && err.response.status === 422) {
            this.errors = ["Credenciales incorrectas."];
          } else {
            this.errors = ["Ocurrió un error inesperado."];
          }
        });
    },
  },
};
</script>
