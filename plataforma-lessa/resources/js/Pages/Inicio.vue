<template>
    <div class="inicio">
      <h3>{{ user.name }}</h3>
      <h3>{{ user.email }}</h3>

      <a href="/logout">Cerrar sesión</a>
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
  