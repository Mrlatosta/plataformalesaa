<template>
  <div class="shadow rounded bg-white m-xl-3 m-5 p-xl-5 p-2 position-relative">
    <div class="image-container">
      <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
    </div>

    <div>
      <h2 style="text-align: center;">Consulta de Muestras</h2>
      <hr />

      <!-- Formulario -->
      <div style="text-align: center;">
        <form @submit.prevent="consultarMuestras">
          <div class="form-container">
            <div style="font-size: 22px;">
              <label for="folio_muestreo">Ingresa tu folio de muestreo:</label>
              <input size="12" type="text" v-model="folio_muestreo" required />
            </div>
          </div>
          <br />
          <button type="submit" class="btn btn-outline-primary">
            Consultar
          </button>
          <button type="button" @click="refresh" class="btn btn-outline-primary">
            <i v-if="loading" class="fas fa-sync-alt fa-spin"></i>
            <span v-if="!loading">Refrescar</span>
          </button>

        </form>
      </div>

      <!-- Mostrar alerta si no se encuentra el folio -->
      <div v-if="alertMessage" class="alert alert-warning alert-dismissible fade show" role="alert" style="text-align: center;">
        <div class="error-message">
          {{ alertMessage }}
        </div>
      </div>

      <!-- Tabla de Folio Info -->
      <div v-if="folioInfo && Object.keys(folioInfo).length > 0">
        <h4 class="table-title">Detalles del Folio</h4>
        <hr />
        <div class="table-container">
          <table class="table" style="text-align: center; margin-top: 20px;">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Nombre de quien autoriza</th>
                <th>Puesto</th>
                <th>Nombre del tomador</th>
                <th>Puesto del tomador</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ folioInfo.fecha }}</td>
                <td>{{ folioInfo.nombre_autoriza_muestras }}</td>
                <td>{{ folioInfo.puesto_autoriza_muestra }}</td>
                <td>{{ folioInfo.nombre_tomador_muestra }}</td>
                <td>{{ folioInfo.puesto_tomador_muestra }}</td>
                <td>{{ folioInfo.estatus?.toUpperCase() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tabla de Muestras -->
      <div v-if="muestras.length">
        <h4 class="table-title">Información de las Muestras</h4>
        <hr />
        <div class="table-container">
          <table class="table" style="text-align: center; margin-top: 20px;">
            <thead>
              <tr>
                <th>Registro</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Temperatura</th>
                <th>Lugar</th>
                <th>Descripción</th>
                <th>Observaciones</th>
                <th>Estatus</th>
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
                <td>{{ muestra.estatus?.toUpperCase() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      folio_muestreo: "",
      folioInfo: null,
      muestras: [],
      alertMessage: "",
      loading: false,
    };
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  methods: {
    async consultarMuestras() {
      this.loading = true;
      this.alertMessage = "";

      const isExtra = this.folio_muestreo.includes("E");
      const folioEndpoint = isExtra ? "/api/folioe-info" : "/api/folio-info";
      const muestrasEndpoint = isExtra ? "/api/consulta-muestrase" : "/api/consulta-muestras";

      try {
        const { data: muestrasData } = await axios.get(muestrasEndpoint, {
          params: { email: this.user.email, folio: this.folio_muestreo },
        });
        this.muestras = muestrasData.data || [];

        const { data: folioData } = await axios.get(folioEndpoint, {
          params: { email: this.user.email, folio: this.folio_muestreo },
        });

        if (folioData.data) {
          if (Array.isArray(folioData.data) && folioData.data.length > 0) {
            this.folioInfo = folioData.data[0];
          } else if (typeof folioData.data === "object") {
            this.folioInfo = folioData.data;
          }
        }

        if (!this.muestras.length && (!this.folioInfo || Object.keys(this.folioInfo).length === 0)) {
          this.alertMessage = "Folio no encontrado.";
        }
      } catch (error) {
        this.alertMessage = error.response?.data?.message || "Error al consultar los datos.";
      } finally {
        this.loading = false;
      }
    },
    refresh() {
  this.alertMessage = ""; // Reinicia mensajes de alerta
  this.consultarMuestras(); // Vuelve a ejecutar la consulta
},

  },
};
</script>


<style scoped>
.error-message {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

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

.btn-outline-primary {
  background-color: white !important;
  border: 1px solid #007bff !important;
  color: #007bff !important;
  padding: 5px 10px;
  display: inline-flex;
  align-items: center;
  margin-top: 10px;
}

.btn-outline-primary i {
  margin-right: 8px;
}

@media (max-width: 767px) {
  .gota-image {
    width: 80px;
    margin-bottom: 15px;
  }

  h2 {
    margin-top: 10px;
  }

  .form-container {
    margin-top: 10px;
  }
}
</style>
