<template>
    <div class="inicio">
      <h1>Bienvenido a la página de inicio</h1>
      <p>Nombre del usuario: {{ nombre }}</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      nombre: {
        type: String,
        required: true,
      },
    },
  };
  </script>
  
  <style scoped>
  .inicio {
    font-family: Arial, sans-serif;
    margin: 20px;
    text-align: center;
  }
  
  h1 {
    color: #333;
  }
  
  p {
    font-size: 2rem;
    color: #555;
  }
  </style>
  