<template>
  <div>
    <header>

      <link rel="shortcut icon" type="image/png" href="{{ asset('../../../favicon.ico') }}">
      <link rel="shortcut icon" sizes="192x192" href="{{ asset('../../../favicon.ico') }}">

      <nav class="navbar navbar-expand-lg bg-body-tertiary shadow fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand ms-3" href="index.html" target="_blank">
            <img src="../../../public/logo.png" alt="Bootstrap" width="140px" class="ms-0 ms-xl-5 mt-2 mb-1">
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

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02" style="margin-right: 150px;">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0" id="listanav">
              <li class="nav-item">
                <a class="nav-link" href="/inicio" style="color: #002668; font-size: 1.3rem; font-weight: 700;">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/consulta-informes" style="color: #002668; font-size: 1.3rem; font-weight: 700;">Consulta tus informes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/consulta-muestras" style="color: #002668; font-size: 1.3rem; font-weight: 700;">Consulta tus muestras</a>
              </li>
              <li class="nav-item" style="display: flex; justify-items: center; text-align: center; vertical-align: middle;">
                <a class="nav-link active" aria-current="page" href="/logout" style="color: #8B0606; font-size: 1rem; margin: 0px">
                  <HiArrowRightStartOnRectangle color="#8B0606" size="40px" />
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main content with background -->
    <main class="bg-container">
      <video autoplay muted loop class="background-video">
        <source src="../../../public/fondo3.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
      </video>
      <slot></slot>
    </main>

    <footer>
      <p>© 2024 Grupo Lesaa. Todos los derechos reservados.</p>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { HiArrowRightStartOnRectangle } from 'vue-icons-plus/hi2';
</script>

<style scoped>
/* Estilo para el header */
header {
  color: rgb(0, 0, 0);
}

#listanav li a {
  font-size: 1.3rem;
  margin-left: 20px;
  margin-right: 20px;
  font-weight: 700;
}

#listanav li a:hover {
  color: #007BFF;
  transform: scale(1.1);
}

/* Estilo para los dropdowns */
.nav-item .dropdown-menu {
  background-color: #fff;
  border: 1px solid #ddd;
}

.dropdown-item {
  color: #002668;
}

.dropdown-item:hover {
  background-color: #f0f0f0;
  color: #007BFF;
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
  position: relative;
  min-height: 100vh;
  padding-top: 150px;
  padding-bottom: 50px;
  z-index: 1;
}

/* Video de fondo */
.background-video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1;
  opacity: 0.2; /* Ajusta la opacidad del video según sea necesario */
}
</style>
