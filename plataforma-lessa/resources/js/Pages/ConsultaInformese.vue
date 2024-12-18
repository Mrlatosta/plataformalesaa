<template>
    <div class="shadow rounded bg-white m-xl-3 m-3 p-xl-5 position-relative">
      <div class="image-container">
        <!-- Imagen posicionada arriba del texto -->
        <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
      </div>
      <h2 style="text-align: center;">Consulta de Informes extra</h2>
      <hr />
      <div style="text-align: center;">
        <form @submit.prevent="consultarFoliose">
          <!-- Contenedor de rango de fechas -->
          <div class="form-container">
            <div>
              <label for="fecha_inicio">Fecha Inicio:</label>
              <input type="date" v-model="fecha_inicio" required />
            </div>
            <div>
              <label for="fecha_fin">Fecha Fin: </label>
              <input type="date" v-model="fecha_fin" required />
            </div>
          </div>
  
          <br />
          <button type="button" class="btn btn-outline-primary" @click="consultarFoliose">Consultar</button>
        </form>
      </div>
      <table class="table" v-if="folios.length" style="text-align: center;">
        <thead>
          <tr>
            <th>Folio</th>
            <th>Fecha</th>
            <th>Estatus</th>
            <th>Descargar</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="folio in folios" :key="folio.folio">
            <td>{{ folio.folio }}</td>
            <td>{{ folio.fecha }}</td>
            <td>{{ folio.estatus.toUpperCase() }}</td>
            <td>
              <button type="button" class="btn btn-primary" @click="descargarFolioe(folio)">
                <img src="../../../public/downloadicon.png" style="filter: invert(100%);" width="20" alt="Descargar" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Mostrar alerta si no hay resultados -->
      <div v-if="noResultMessage" class="alert alert-warning alert-dismissible fade show" role="alert" style="text-align: center;">
        {{ noResultMessage }}
      </div>
    </div>
  </template>
  
  <script>
  import Layout from "@/components/Layout.vue";
  import axios from "axios";
  
  export default {
    components: {
      Layout,
    },
    props: {
      user: Object,
    },
    data() {
      return {
        fecha_inicio: "",
        fecha_fin: "",
        folios: [],
        noResultMessage: "", // Agregar esta propiedad
      };
    },
    methods: {
      async consultarFoliose() {
        if (!this.user || !this.user.email) {
          console.error("El usuario no está definido o no tiene un email:", this.user);
          return;
        }
  
        try {
          const response = await axios.get("/api/foliose", {
            params: {
              email: this.user.email,
              fecha_inicio: this.fecha_inicio,
              fecha_fin: this.fecha_fin,
            },
          });
          this.folios = response.data.data; // Actualiza correctamente 'folios'
          
          // Si no hay resultados, mostrar el mensaje
          if (this.folios.length === 0) {
            this.noResultMessage = "No se encontraron folios en ese rango de fechas";
          } else {
            this.noResultMessage = ""; // Limpiar el mensaje si hay resultados
          }
        } catch (error) {
          console.error("Error al consultar los folios:", error);
        }
      },
      descargarFolioe(folio) {
        console.log(`Descargando folio ${folio.folio}`); // Implementar lógica de descarga
      },
    },
  };
  </script>
  
  <style scoped>
  /* Posicionar el contenedor principal */
  .position-relative {
    position: relative;
  }
  
  /* Contenedor para la imagen */
  .image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px; /* Espacio entre la imagen y el texto */
  }
  
  /* Imagen en la parte superior de la pantalla */
  .gota-image {
    width: 100px; /* Tamaño de la imagen */
    height: auto; /* Mantener proporciones */
    z-index: 10; /* Asegura que esté por encima de otros elementos */
  }
  
  /* Contenedor de fechas */
  .form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 30px; /* Asegura que las fechas no se solapen con la imagen */
  }
  
  /* Media query para pantallas pequeñas */
  @media (max-width: 767px) {
    /* Asegura que la imagen esté centrada y encima del texto */
    .image-container {
      flex-direction: column;
      align-items: center;
    }
  
    .gota-image {
      width: 80px; /* Reducir el tamaño de la imagen en móvil */
      margin-bottom: 15px; /* Espacio entre la imagen y el texto */
    }
  
    /* El texto de la cabecera debería estar centrado */
    h2 {
      margin-top: 10px;
    }
  
    .table {
      width: 100%;
      font-size: 0.8rem;
    }
  }
  </style>
  