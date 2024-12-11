
<template>
    <div>
      <header>

        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow fixed-top" >
        <div class="container-fluid">


    <a class="navbar-brand" href="#">
      <img src="../../../public/logo.png" alt="Bootstrap" width="100">
    </a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav  me-auto mb-2 mb-lg-0" >
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/inicio" style="color: #002668;">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/consulta-informes" style="color: #002668;">Consulta Informes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true" >Segimiento Muestras</a>
        </li>
      </ul>
      
    </div>

    
  </div>
</nav>

        <!-- <nav>
          <ul>
            <li><a href="/inicio">Inicio</a></li>
            <li><a href="/consulta-informes">Consulta de Informes</a></li>
            <li><a href="/seguimiento-muestras">Seguimiento de Muestras</a></li>
          </ul>
        </nav> -->
      </header>
      <main style="margin-top: 150px; height: 100vh;">
        <slot></slot>
      </main>
      <footer>
        <p>© 2024 Grupo Lesaa. Todos los derechos reservados.</p>
      </footer>
    </div>
  </template>
  
  <script>
  export default {
    name: "Layout",
  };
  </script>
  
  <style scoped>
  header {

    color: rgb(0, 0, 0);

  }
  

  
 
  footer {
    text-align: center;
    padding: 1rem;
    background: #90ABDD;
    margin-top: 2rem;
  }
  </style>