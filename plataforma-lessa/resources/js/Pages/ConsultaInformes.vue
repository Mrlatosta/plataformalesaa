<template>
  <div class="shadow rounded bg-white m-xl-3 m-3 p-xl-5 position-relative">
    <div class="image-container">
      <!-- Imagen posicionada arriba del texto -->
      <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
    </div>
    <h2 style="text-align: center;">Consulta de Informes</h2>
    <hr>
    <div style="text-align: center;">
      <form @submit.prevent="consultarFolios">
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
        <button type="button" class="btn btn-outline-primary" @click="consultarFolios">Consultar</button>

        <!-- Botón Refrescar -->
        <button type="button" @click="refresh" class="btn btn-outline-primary">
          <i v-if="loading" class="fas fa-sync-alt fa-spin"></i>
          <span v-if="!loading">Refrescar</span>
        </button>
      </form>
    </div>

    <!-- Mensaje si no se encuentran folios -->
    <div v-if="noFolios" class="alert alert-warning no-folios-alert" role="alert">
      No se encontraron folios en ese rango de fechas.
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
            <button type="button" class="btn btn-primary" @click="descargarFolio(user.email, folio.folio)">
              <img src="../../../public/downloadicon.png" style="filter: invert(100%);" width="20" alt="Descargar">
            </button>
          </td>
        </tr>
      </tbody>
    </table>
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
      noFolios: false,
      loading: false, // Para manejar el estado de carga
    };
  },
  methods: {
    // Método para consultar los folios
    async consultarFolios() {
      if (!this.user || !this.user.email) {
        console.error("El usuario no está definido o no tiene un email:", this.user);
        return;
      }

      try {
        const response = await axios.get("/api/folios", {
          params: {
            email: this.user.email,
            fecha_inicio: this.fecha_inicio,
            fecha_fin: this.fecha_fin,
          },
        });

        // Si no hay folios en la respuesta, se muestra el mensaje
        if (response.data.data.length === 0) {
          this.noFolios = true;
        } else {
          this.noFolios = false;
        }

        this.folios = response.data.data;
      } catch (error) {
        console.error("Error al consultar los folios:", error);
      }
    },

    // Método para refrescar la consulta
    refresh() {
      console.log("Refrescando...");
      this.loading = true; // Iniciar estado de carga
      setTimeout(() => {
        this.loading = false; // Terminar estado de carga después de 2 segundos
      }, 2000);
    },

    // Método para descargar un archivo asociado al folio
    async descargarFolio(userEmail, folio) {
      try {
        const token = localStorage.getItem('authToken');
        if (!token) {
          console.error('Token no disponible');
          return;
        }

        const response = await axios.get(`/api/file-url/${userEmail}/${folio}`, {
          headers: {
            'Authorization': `Bearer ${token}`,
          },
        });

        const fileData = response.data.data;
        const fileUrl = fileData.url;
        const link = document.createElement('a');
        link.href = fileUrl;
        link.download = folio;
        link.click();
      } catch (error) {
        console.error('Error al intentar descargar el archivo:', error);
        alert('Ocurrió un error al intentar descargar el archivo');
      }
    }
  },
};
</script>

<style scoped>
/* Agrega aquí tus estilos adicionales si los necesitas */
.position-relative {
  position: relative;
}

/* Contenedor para la imagen */
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

.form-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 30px;
}

/* Estilo para el botón de refresco */
.btn-refresh {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  margin-top: 10px;
}

.btn-refresh i {
  margin-right: 8px;
}

/* Media query para pantallas pequeñas */
@media (max-width: 767px) {
  .image-container {
    flex-direction: column;
    align-items: center;
  }

  .gota-image {
    width: 80px;
    margin-bottom: 15px;
  }

  h2 {
    margin-top: 10px;
  }

  .table {
    width: 100%;
    font-size: 0.8rem;
  }
}
</style>
