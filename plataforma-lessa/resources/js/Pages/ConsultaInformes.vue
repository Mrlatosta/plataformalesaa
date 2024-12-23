<template>
  <div class="main-container">
    <!-- Contenedor Principal -->
    <div class="shadow rounded bg-white m-3 p-4 position-relative">
      <div class="image-container">
        <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
      </div>
      <h2 class="text-center">Consulta de Informes</h2>
      <hr />
      <form @submit.prevent="consultarFolios" class="form-container">
        <div class="form-group">
          <label for="fecha_inicio">Fecha Inicio:</label>
          <input type="date" v-model="fecha_inicio" class="form-control" required />
        </div>
        <div class="form-group">
          <label for="fecha_fin">Fecha Fin:</label>
          <input type="date" v-model="fecha_fin" class="form-control" required />
        </div>
        <div class="button-group">
          <button type="button" class="btn btn-primary" @click="consultarFolios">
            Consultar
          </button>
          <button type="button" class="btn btn-outline-primary" @click="refresh">
            <i v-if="loading" class="fas fa-sync-alt fa-spin"></i>
            <span v-if="!loading">Refrescar</span>
          </button>
        </div>
      </form>
      <div v-if="noFolios" class="alert alert-warning text-center mt-3">
        No se encontraron folios en ese rango de fechas.
      </div>
    </div>

    <!-- Tablas de datos -->
    <div v-if="folios.length" class="table-container">
      <div class="shadow rounded bg-white m-3 p-4 position-relative">
        <h3 class="text-primary text-center mt-4">Folios Generales</h3>
        <hr />
        <div class="table-responsive">
          <table class="table table-striped">
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
                    Descargar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="foliose.length" class="table-container">
      <div class="shadow rounded bg-white m-3 p-4 position-relative">
        <h3 class="text-primary text-center mt-4">Folios Extras</h3>
        <hr />
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Estatus</th>
                <th>Descargar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="folio in foliose" :key="folio.folio">
                <td>{{ folio.folio }}</td>
                <td>{{ folio.fecha }}</td>
                <td>{{ folio.estatus.toUpperCase() }}</td>
                <td>
                  <button type="button" class="btn btn-primary" @click="descargarFolio(user.email, folio.folio)">
                    Descargar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
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
      fecha_inicio: "",
      fecha_fin: "",
      folios: [],
      foliose: [],
      noFolios: false,
      loading: false,
    };
  },
  methods: {
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

        if (response.data.data.length === 0) {
          this.noFolios = true;
        } else {
          console.log("Folios obtenidos:", response.data.data);
          this.noFolios = false;
        }

        this.folios = response.data.data;
      } catch (error) {
        console.error("Error al consultar los folios:", error);
      }

      try {
        this.loading = true;
        const response = await axios.get("/api/foliose", {
          params: {
            email: this.user.email,
            fecha_inicio: this.fecha_inicio,
            fecha_fin: this.fecha_fin,
          },
        });
        console.log("FoliosE obtenidos:", response.data.data);
        this.foliose = response.data.data;

        if (this.folios.length === 0 && this.foliose.length === 0) {
          this.noResultMessage = "No se encontraron folios en ese rango de fechas";
        } else {
          this.noResultMessage = "";
        }
      } catch (error) {
        console.error("Error al consultar los folios:", error);
      } finally {
        this.loading = false;
      }
    },

    refresh() {
      console.log("Refrescando...");
      this.loading = true;
      this.consultarFolios().finally(() => {
        this.loading = false;
      });
    },

    async descargarFolio(userEmail, folio) {
      try {
        const token = localStorage.getItem("authToken");
        if (!token) {
          console.error("Token no disponible");
          return;
        }

        const response = await axios.get(`/api/file-url/${userEmail}/${folio}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        const fileData = response.data.data;
        const fileUrl = fileData.url;
        const link = document.createElement("a");
        link.href = fileUrl;
        link.download = folio;
        link.click();
      } catch (error) {
        console.error("Error al intentar descargar el archivo:", error);
        alert("Ocurrió un error al intentar descargar el archivo");
      }
    },
  },
};
</script>

<style scoped>
/* General */
.main-container {
  margin: 0 auto;
  max-width: 100%;
  padding: 15px;
}

.image-container {
  display: flex;
  justify-content: center;
  margin-bottom: 15px;
}

.gota-image {
  width: 80px;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.button-group {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.table-container {
  margin: 15px 0;
}

.table-responsive {
  overflow-x: auto;
}

/* Media Queries */
@media (max-width: 768px) {
  h2 {
    font-size: 1.5rem;
  }

  .gota-image {
    width: 60px;
  }

  .form-container {
    gap: 10px;
  }

  .table {
    font-size: 0.9rem;
  }
}
</style>
