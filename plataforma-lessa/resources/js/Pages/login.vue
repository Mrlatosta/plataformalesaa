
<template>
  <div>

    <section class="h-100 gradient-form">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="../../../public/gota.png" alt="Gota" class="gota-image" width="150px" />
                  <h4 class="mt-1 mb-5 pb-1">Accede a la plataforma LESAA</h4>
                </div>

                <form @submit.prevent="login">
                  <p>Por favor, ingresa con tus credenciales</p>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="form2Example11" class="form-control" v-model="form.email"
                      placeholder="Folio del cliente"  />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form2Example22" class="form-control" placeholder="Contraseña" v-model="form.password"/>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Ingresar</button>
                  </div>

                  <div class=" align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2" style="text-align: center;">¿Aún no tienes una cuenta? <br><a href="mailto:atencionaclienteslab.lesa@gmail.com">Solicita una a atención a clientes</a></p>
                    
                    
                    
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-5">Somos mucho más que una empresa</h4>
                <p class="mb-4">Grupo LESAA es mucho más que un simple centro de servicios de laboratorio. Es un referente en la calidad y seguridad alimentaria en México, 
                  ofreciendo soluciones innovadoras que abarcan desde análisis de agua y alimentos hasta auditorías especializadas y programas de 
                  capacitación para empresas que buscan cumplir con normativas como el Distintivo H (NMX-F-605-NORMEX-2018).</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <!-- <form @submit.prevent="login">
      <div>
        <label for="email">Folio</label>
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
    </form> -->
  </div>
</template>


<style scoped>
.gradient-custom-2 {
  /* fallback for old browsers */
  background: #1b37a5;
  
  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(to right, #0e0a7b, #1492e1, #07509f, #3c6fe7);
  
  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right, #0e0a7b, #1492e1, #07509f, #3c6fe7);
  }
  
  @media (min-width: 768px) {
  .gradient-form {
  height: 100vh !important;
  }
  }
  @media (min-width: 769px) {
  .gradient-custom-2 {
  border-top-right-radius: .3rem;
  border-bottom-right-radius: .3rem;
  }
  }
</style> 


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
        .then((response) => {
          localStorage.setItem("authToken", response.data.token);
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
