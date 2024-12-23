<template>
  <div class="shadow rounded bg-white m-xl-3 m-5 p-xl-5 p-2 position-relative">
    <div class="image-container">
      <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
    </div>
<!-- #################################################################################### -->
 <div>
    <h2 style="text-align: center;">Consulta de Muestras extra</h2>
    <hr />

    <div style="text-align: center;">
      <form @submit.prevent="consultarMuestrase">
        <div class="form-container">
          <div style="font-size: 22px;">
            <label for="folio_muestreo">Ingresa tu folio de muestreo:</label>
            <input size="12" type="text" v-model="folio_muestreoe" required />
          </div>
        </div>
        <br />
        <button type="button" class="btn btn-outline-primary" @click="consultarMuestrase">
          Consultar
        </button>

        <!-- Botón Refrescar -->
        <button type="button" @click="refresh" class="btn btn-outline-primary">
          <i v-if="loading" class="fas fa-sync-alt fa-spin"></i>
          <span v-if="!loading">Refrescar</span>
        </button>
      </form>
    </div>

    <!-- Alerta de no encontrado -->
    <div v-if="alertMessage" class="alert alert-warning mt-3" role="alert" style="text-align: center;">
      {{ alertMessage }}
    </div>

    <!-- Tabla de Folio Info -->
  <div v-if="Object.keys(folioeInfo).length">
    <h4 class="table-title">Detalles del folio extra</h4>
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
          <tr>
            <td>{{ folioeInfo.fecha }}</td>
            <td>{{ folioeInfo.nombre_autoriza_muestras }}</td>
            <td>{{ folioeInfo.puesto_autoriza_muestra }}</td>
            <td>{{ folioeInfo.nombre_tomador_muestra }}</td>
            <td>{{ folioeInfo.puesto_tomador_muestra }}</td>
            <td>{{ folioeInfo.estatus.toUpperCase() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


    <!-- Tabla de Muestras -->
    <div v-if="muestras.length">
      <h4 class="table-title">Información de las muestras extra</h4>
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
              <th>Estatus de la muestra</th>
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
</div>
<!-- #################################################################################### -->
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
      muestras: [], // Asegura que muestras siempre sea un array vacío
      folioeInfo: {}, // Asegura que folioeInfo siempre sea un array vacío
      folio_muestreoe: "", // Folio de muestreo ingresado
      alertMessage: "", // Mensaje de alerta
      loading: false, // Para manejar el estado de carga
    };
  },
  methods: {
    async consultarMuestrase() {
      if (!this.user || !this.user.email) {
        console.error("El usuario no está definido o no tiene un email:", this.user);
        return;
      }

      try {
        // Obtener la información de las muestras
        const muestrasResponse = await axios.get("/api/muestrase", {
          params: {
            email: this.user.email,
            folio: this.folio_muestreoe,
          },
        });
        console.log("Muestras obtenidas:", muestrasResponse.data.data);
        this.muestras = muestrasResponse.data.data;

        // Obtener la información específica del folio
        const folioResponse = await axios.get("/api/folioe-info", {
          params: {
            email: this.user.email,
            folio: this.folio_muestreoe,
          },
        });
        console.log("Folio info obtenida:", folioResponse.data.data);
        this.folioeInfo = folioResponse.data.data;

        // Si no se encuentra el folio, mostrar la alerta
        if (this.muestras.length === 0 && this.folioeInfo.length === 0) {
          this.alertMessage = "No se encontró el folio solicitado con las muestras extra";
        } else {
          this.alertMessage = ""; // Limpiar alerta si hay datos
        }
      } catch (error) {
        console.error("Error al consultar los datos:", error);
      }
    },

    // Método para refrescar la página
    refresh() {
  console.log("Refrescando...");
  this.loading = true; // Iniciar estado de carga
  this.consultarFolios()  // Llamada a la función que consulta los datos
    .finally(() => {
      this.loading = false; // Terminar estado de carga
    });
},

  },
};
</script>

<style scoped>
.position-relative {
  position: relative;
}

.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.gota-image {
  width: 100px;
  height: auto;
  z-index: 10;
}

.table-title {
  margin-top: 30px;
  text-align: center;
  font-weight: bold;
  font-size: 1.2rem;
  color: #333;
}

.table-container {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  margin-top: 10px;
}

/* Estilo para el botón de refresco */
.btn-outline-primary {
  background-color: white !important; /* Fondo blanco */
  border: 1px solid #007bff !important; /* Borde azul */
  color: #007bff !important; /* Texto azul */
  padding: 5px 10px;
  display: inline-flex;
  align-items: center;
  margin-top: 10px;
}

.btn-outline-primary i {
  margin-right: 8px;
}

/* Media query para pantallas pequeñas */
@media (max-width: 767px) {
  .gota-image {
    width: 80px;
  }

  .table {
    width: 100%;
    font-size: 0.8rem;
  }
}
</style>
