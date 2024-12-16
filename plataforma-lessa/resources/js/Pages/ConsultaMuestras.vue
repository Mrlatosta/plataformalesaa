<template>
  <div class="shadow rounded bg-white m-xl-3 m-5 p-xl-5 p-2 position-relative">
    <div class="image-container">
      <!-- Imagen posicionada arriba del texto -->
      <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
    </div>
    <h2 style="text-align: center;">Consulta de Muestras</h2>
    <hr />

    <!-- Formulario -->
    <div style="text-align: center;">
      <form @submit.prevent="consultarMuestras">
        <div class="form-container">
          <div style="font-size: 22px;">
            <label for="folio_muestreo">Ingresa tu folio de muestreo:</label>
            <input type="text" v-model="folio_muestreo" required />
          </div>
        </div>
        <br />
        <button type="button" class="btn btn-outline-primary" @click="consultarMuestras">
          Consultar
        </button>
      </form>
    </div>

    <!-- Tabla de Folio Info -->
    <div v-if="folioInfo.length">
      <h4 class="table-title">Detalles del folio</h4>
      <hr />
      <div class="table-container">
        <table class="table" style="text-align: center; margin-top: 20px;">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Nombre de quien autoriza las muestras</th>
              <th>Puesto del que autoriza</th>
              <th>Nombre del tomador de muestras</th>
              <th>Puesto del tomador de muestras</th>
              <th>Estatus del folio</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="info in folioInfo" :key="info.fecha">
              <td>{{ info.fecha }}</td>
              <td>{{ info.nombre_autoriza_muestras }}</td>
              <td>{{ info.puesto_autoriza_muestra }}</td>
              <td>{{ info.nombre_tomador_muestra }}</td>
              <td>{{ info.puesto_tomador_muestra }}</td>
              <td>{{ info.estatus.toUpperCase() }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Tabla de Muestras -->
    <div v-if="muestras.length">
      <h4 class="table-title">Información de las muestras</h4>
      <hr />
      <div class="table-container">
        <table class="table" style="text-align: center; margin-top: 20px;">
          <thead>
            <tr>
              <th>Registro muestra</th>
              <th>Fecha muestreo</th>
              <th>Nombre muestra</th>
              <th>Cantidad aprox</th>
              <th>Temperatura</th>
              <th>Lugar toma</th>
              <th>Descripción toma</th>
              <th>Observaciones</th>
              <th>Estatus de la muetra</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="muestra in muestras" :key="muestra.registro_muestra">
              <td>{{ muestra.registro_muestra }}</td>
              <td>{{ muestra.fecha_muestreo }}</td>
              <td>{{ muestra.nombre_muestra }}</td>
              <td>{{ muestra.cantidad_aprox }}</td>
              <td>{{ muestra.temperatura }}</td>
              <td>{{ muestra.lugar_toma }}</td>
              <td>{{ muestra.descripcion_toma }}</td>
              <td>{{ muestra.observaciones }}</td>
              <td>{{ muestra.estatus.toUpperCase() }}</td>
            </tr>
          </tbody>
        </table>
      </div>
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
      muestras: [],
      folioInfo: [], // Aquí se guarda la información de obtenerFolioInfo()
      folio_muestreo: "", // Input del folio de muestreo
    };
  },
  methods: {
    async consultarMuestras() {
      if (!this.user || !this.user.email) {
        console.error("El usuario no está definido o no tiene un email:", this.user);
        return;
      }

      try {
        // Obtener la información de las muestras
        const muestrasResponse = await axios.get("/api/muestras", {
          params: {
            email: this.user.email,
            folio: this.folio_muestreo,
          },
        });
        this.muestras = muestrasResponse.data.data;

        // Obtener la información específica del folio
        const folioResponse = await axios.get("/api/folio-info", {
          params: {
            email: this.user.email,
            folio: this.folio_muestreo,
          },
        });
        this.folioInfo = folioResponse.data.data;
      } catch (error) {
        console.error("Error al consultar los datos:", error);
      }
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

/* Títulos de las tablas */
.table-title {
  margin-top: 30px;
  text-align: center;
  font-weight: bold;
  font-size: 1.2rem;
  color: #333;
}

/* Contenedor para permitir desplazamiento horizontal en tablas */
.table-container {
  overflow-x: auto; /* Permite el scroll horizontal en tablas */
  -webkit-overflow-scrolling: touch; /* Mejora el scroll en dispositivos iOS */
  margin-top: 10px;
}

/* Media query para pantallas pequeñas */
@media (max-width: 767px) {
  /* Imagen centrada y adaptada en móvil */
  .gota-image {
    width: 80px; /* Reducir el tamaño de la imagen en móvil */
    margin-bottom: 15px; /* Espacio entre la imagen y el texto */
  }

  /* Alinear el texto en pantallas pequeñas */
  h2 {
    margin-top: 10px;
  }

  /* Ajustar márgenes en el formulario */
  .form-container {
    margin-top: 10px;
  }
}
</style>
