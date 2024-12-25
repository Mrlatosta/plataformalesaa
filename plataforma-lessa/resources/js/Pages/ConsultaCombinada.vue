<template>
    <div class="shadow rounded bg-white m-xl-3 m-5 p-xl-5 p-2 position-relative">
      <div class="image-container">
        <!-- Imagen posicionada arriba del texto -->
        <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
      </div>
  
  <div>
      <h2 style="text-align: center;">Consulta de Muestras</h2>
      <hr />
  <!-- ################################################################################################################################### -->
      <!-- Formulario -->
      <div style="text-align: center;">
        <form @submit.prevent="consultarMuestras">
          <div class="form-container">
            <div style="font-size: 22px;">
              <label for="folio_muestreo">Ingresa tu folio de muestreo:</label>
              <input size="12" type="text" v-model="folio_muestreo" required />
            </div>
          </div>
          <br/>
          <button type="button" class="btn btn-outline-primary" @click="consultarMuestras">
            Consultar
          </button>
  
          <!-- Botón Refrescar -->
          <button type="button" @click="refresh" class="btn btn-outline-primary">
            <i v-if="loading" class="fas fa-sync-alt fa-spin"></i>
            <span v-if="!loading">Refrescar</span>
          </button>
        </form>
      </div>
  
      <!-- Mostrar alerta si no se encuentra el folio -->
      <div v-if="noResultMessage" class="alert alert-warning alert-dismissible fade show" role="alert" style="text-align: center;">
        <div class="error-message">
          {{ noResultMessage }}
        </div>
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
  <!-- ################################################################################################################ -->
  <!-- ############################################################################################################### -->
  
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
        folioInfo: [],
        folio_muestreo: "",
        noResultMessage: "",
        loading: false, // Para manejar el estado de carga
      };
    },
    methods: {
      async consultarMuestras() {
        if (!this.user || !this.user.email) {
          console.error("El usuario no está definido o no tiene un email:", this.user);
          return;
        }
  
        try {
          const muestrasResponse = await axios.get("/api/consulta-muestras", {
            params: {
              email: this.user.email,
              folio: this.folio_muestreo,
            },
          });
          this.muestras = muestrasResponse.data.data;
  
          const folioResponse = await axios.get("/api/folio-info", {
            params: {
              email: this.user.email,
              folio: this.folio_muestreo,
            },
          });
          this.folioInfo = folioResponse.data.data;
  
          if (this.muestras.length === 0 && this.folioInfo.length === 0) {
            this.noResultMessage = "Folio de Muestras no encontrado en la base de datos";
          } else {
            this.noResultMessage = "";
          }
        } catch (error) {
          console.error("Error al consultar los datos:", error);
        }
      },
          refresh() {
        console.log("Refrescando...");
        this.loading = true; // Iniciar estado de carga
        this.consultarMuestras()  // Llamada a la función que consulta los datos
          .finally(() => {
            this.loading = false; // Terminar estado de carga
          });
      },
  
    },
  };
  </script>
  
  <style scoped>
  /* Error message styling */
  .error-message {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Asegura que el mensaje se centre verticalmente */
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
  