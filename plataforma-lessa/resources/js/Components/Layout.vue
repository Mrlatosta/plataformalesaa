<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary shadow fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand ms-3" href="#">
            <img src="../../../public/logo.png" alt="Bootstrap" width="160px" class="ms-0 ms-xl-5 mt-2 mb-1" >
          </a>

          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02" style=" margin-right: 150px; " >
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0" id="listanav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/inicio" style="color: #002668;">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/consulta-informes" style="color: #002668;">Consulta Informes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/consulta-muestras">Seguimiento Muestras</a>
              </li>
              <li class="nav-item" style="display: flex; justify-items: center; text-align: center; vertical-align: middle;">
                
                <a class="nav-link active" aria-current="page" href="/logout" style="color: #8B0606; font-size: 1rem; margin: 0px">
                  <HiArrowRightStartOnRectangle color="#8B0606" size="40px" /> </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main content with background -->
    <main class="bg-container">
      <slot></slot>
    </main>

    <footer>
      <p>© 2024 Grupo Lesaa. Todos los derechos reservados.</p>
    </footer>
  </div>
</template>

<script>


</script>

<script setup lang="ts">
  import { HiArrowRightStartOnRectangle } from 'vue-icons-plus/hi2';
</script>

<script lang="ts">
export default {
  name: "Layout",
};
</script>

<style scoped>
/* Estilo para el header */
header {
  color: rgb(0, 0, 0);
}

#listanav li a {
  font-size: 1.5rem;
  margin-left: 20px;
  margin-right: 20px;
  font-weight: 700;
}

#listanav li a:hover {
  color: #007BFF;
  transform: scale(1.1);
}

/* Estilo para el footer */
footer {
  color: white;
  text-align: center;
  padding: 1rem;
  background: #040c5e;
  margin-top: 2rem;
}

/* Contenedor principal con fondo */
.bg-container {
  position: relative; /* Necesario para que el pseudo-elemento funcione */
  min-height: 100vh; /* Altura mínima */
  padding-top: 150px; /* Espacio para el header */
  padding-bottom: 50px; /* Espacio para el footer */
  z-index: 1; /* Asegurar que el contenido esté encima del fondo */
}

/* Fondo con opacidad */
.bg-container::before {
  content: ''; /* Pseudo-elemento vacío */
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('../../../public/fondo2.png'); /* Ruta de la imagen */
  background-size: cover; /* Que cubra todo */
  background-repeat: no-repeat; /* Sin repeticiones */
  background-position: center; /* Centrar la imagen */
  opacity: 0.2; /* Opacidad solo para la imagen de fondo */
  z-index: -1; /* Asegurar que esté detrás del contenido */ 
}
</style>
