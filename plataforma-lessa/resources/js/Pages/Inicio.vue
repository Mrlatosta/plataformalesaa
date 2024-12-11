<template>
  <div id="inicio">
    <h1 class="" style="color: #002668;">¡Bienvenido {{ user.name }} a la plataforma Lesaa!</h1>
    <p class="" style="color: #002668;">Tu usuario: {{ user.email }}</p>
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
#inicio {
  font-family: Arial, sans-serif;
  margin: 20px;
  text-align: center;
}

h1 {
  color: #007BFF;
}

p {
  font-size: 1.2rem;
  color: #333;
}
</style>