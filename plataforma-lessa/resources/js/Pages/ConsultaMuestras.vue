<template>
  <div class="main-container">
    <!-- Contenedor de la cabecera -->
    <div class="section-container shadow rounded bg-white p-4 position-relative">
      <div class="image-container">
        <img src="../../../public/gota.png" alt="Gota" class="gota-image" style="width: 60px;" />
      </div>
      <h2 class="text-center" style="color: #002668;" >Consulta de Muestras</h2>
      <hr />
      <form @submit.prevent="consultarMuestras" class="text-center">
        <div class="form-group">
          <label for="folio_muestreo" class="form-label">Ingresa tu folio de muestreo:</label>
          <input
            size="12"
            type="text"
            v-model="folio_muestreo"
            required
            class="form-control text-center"
          />
        </div>
        <div class="button-group mt-3">
          <button type="submit" class="btn btn-primary">Consultar</button>
          <button type="button" @click="refresh" class="btn btn-outline-primary">
            <i v-if="loading" class="fas fa-sync-alt fa-spin"></i>
            <span v-if="!loading">Refrescar</span>
          </button>
        </div>
      </form>
      <div v-if="alertMessage" class="alert alert-warning text-center mt-3">
        {{ alertMessage }}
      </div>
    </div>

    <!-- Contenedor de la tabla de folio -->
    <div v-if="folioInfo && Object.keys(folioInfo).length > 0" class="section-container shadow rounded bg-white p-4 mt-4">
      <h4 class="text-center" style="color: #002668;">Detalles del Folio</h4>
      <hr />
      <div class="table-responsive">
        <table class="table table-striped text-center ">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Nombre de quien autoriza las muestras</th>
              <th>Puesto de quien autoriza las muestras</th>
              <th>Nombre del tomador de las muestras</th>
              <th>Puesto del tomador de las muestras</th>
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

    <!-- Contenedor de la tabla de muestras -->
    <div v-if="muestras.length" class="section-container shadow rounded bg-white p-4 mt-4">
      <h4 class="text-center" style="color: #002668;">Información de las Muestras</h4>
      <hr />
      <div class="table-responsive">
        <table class="table table-striped text-center">
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
.image-container {
  display: flex;
  justify-content: center;
}
.main-container {
  padding: 20px;
}

.section-container {
  margin-bottom: 20px; /* Separación entre contenedores */
}

.shadow {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.text-center {
  text-align: center;
}

.form-control {
  max-width: 400px;
  margin: 0 auto;
}

.button-group {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.table-responsive {
  overflow-x: auto;
}
</style>