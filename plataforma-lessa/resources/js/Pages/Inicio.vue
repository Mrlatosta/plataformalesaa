<template>
  <div>
    <h1>¡Bienvenido a la plataforma Lesaa!</h1>
    <div class="shadow rounded p-xl-5 p-2 position-relative gradient-custom-2" id="conte">
      <p class="pnombre" style="text-align: center; color: white;">¡Hola, {{ user.name }}!</p>
      <p class="pdos" style="text-align: center; color: white;">Consulta fácilmente la información de tus informes o muestras desplazándote en el panel superior de la página.</p>
    </div>

  </div>
    

  
</template>

<script>
export default {
  props: {
    user: Object,
  },
};
</script>

<style scoped>

/* .caja {
  background-color: rgb(255, 255, 255);
  font-size: 50 px;
  color: #0a1529;
  font-family: Arial, sans-serif;
  margin: 20px;
  text-align: center;
  padding: 20px;
} */

.gradient-custom-2 {
  /* fallback for old browsers */
  background: #1b37a5;
  
  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(to right, #0e0a7b, #1492e1, #07509f, #3c6fe7);
  
  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right, #0e0a7b, #1492e1, #07509f, #3c6fe7);
  }

  #conte{
    margin: 200px;
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

  @media (max-width: 767px) {
  /* Asegura que la imagen esté centrada y encima del texto */
  
  #conte{
    margin: 20px;
  }

  .pdos  {
    font-size: 1rem;
  }

  .pnombre {
    font-size: 1rem;
  }

  
}



h1 {
  color: #002668;
  font-family: Arial, sans-serif;
  margin: 20px;
  text-align: center;
}

p {
  font-size: 2rem;
  color: #333;
}
</style>