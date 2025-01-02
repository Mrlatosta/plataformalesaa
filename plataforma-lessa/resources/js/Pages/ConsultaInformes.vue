<template>
  <div class="main-container">
    <!-- Contenedor Principal -->
    <div class="section-container">
      <div class="shadow rounded bg-white p-4 position-relative">
        <div class="image-container">
          <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
        </div>
        <h2 class="text-center" style="color: #002668;">Consulta de Informes</h2>
        <hr />

        <!-- Selección del tipo de búsqueda -->
        <div class="form-check">
          <input
            type="radio"
            id="buscarPorFechas"
            v-model="tipoBusqueda"
            value="fechas"
            class="form-check-input"
          />
          <label for="buscarPorFechas" class="form-check-label">Buscar por Rango de Fechas</label>
        </div>
        <div class="form-check">
          <input
            type="radio"
            id="buscarPorFolio"
            v-model="tipoBusqueda"
            value="folio"
            class="form-check-input"
          />
          <label for="buscarPorFolio" class="form-check-label">Buscar por Folio</label>
        </div>
        <hr />

        <!-- Formulario de búsqueda -->
        <form v-if="tipoBusqueda === 'fechas'" @submit.prevent="consultarFolios" class="form-container">
          <div class="form-group">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input
              type="date"
              id="fecha_inicio"
              v-model="fecha_inicio"
              class="form-control date-input"
              required
            />
          </div>
          <div class="form-group">
            <label for="fecha_fin">Fecha Fin:</label>
            <input
              type="date"
              id="fecha_fin"
              v-model="fecha_fin"
              class="form-control date-input"
              required
            />
          </div>
          <div class="button-group">
            <button type="submit" class="btn btn-primary">Consultar</button>
          </div>
        </form>

        <form v-if="tipoBusqueda === 'folio'" @submit.prevent="consultarPorFolio" class="form-container">
          <div class="form-group">
            <label for="folio">Folio:</label>
            <input
              type="text"
              id="folio"
              v-model="folio"
              class="form-control"
              placeholder="Ingrese el número de folio"
              required
            />
          </div>
          <div class="button-group">
            <button type="submit" class="btn btn-primary">Consultar</button>
          </div>
        </form>

        <div v-if="noFolios" class="alert alert-warning text-center mt-3">
          No se encontraron folios.
        </div>
      </div>
    </div>

    <!-- Tablas de datos -->
    <div class="section-container">
      <div v-if="folios.length" class="shadow rounded bg-white p-4 position-relative">
        <h3 class="text-primary text-center mt-4 custom-color">Informes Generales</h3>
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
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="descargarFolio(user.email, folio.folio)"
                  >
                    Descargar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="section-container">
      <div v-if="foliose.length" class="shadow rounded bg-white p-4 position-relative">
        <h3 class="text-primary text-center mt-4 custom-color">Extras</h3>
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
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="descargarFolio(user.email, folio.folio)"
                  >
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
import Layout from "@/Components/Layout.vue";
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
      folio: "",
      tipoBusqueda: "fechas", // Estado para el tipo de búsqueda
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

        this.folios = response.data.data || [];
        this.noFolios = this.folios.length === 0;

        const responseExtra = await axios.get("/api/foliose", {
          params: {
            email: this.user.email,
            fecha_inicio: this.fecha_inicio,
            fecha_fin: this.fecha_fin,
          },
        });
        this.foliose = responseExtra.data.data || [];

        if (this.folios.length === 0 && this.foliose.length === 0) {
          this.noFolios = true;
        }
      } catch (error) {
        console.error("Error al consultar los folios:", error);
      }
    },

    async consultarPorFolio() {
      if (!this.user || !this.user.email) {
        console.error("El usuario no está definido o no tiene un email:", this.user);
        return;
      }

      if (!this.folio) {
        alert("Por favor, ingrese un número de folio.");
        return;
      }

      try {
        let response;
        if (this.folio.endsWith("E")) {
          response = await axios.get("/api/foliose/folio", {
            params: {
              email: this.user.email,
              folio: this.folio,
            },
          });
          this.foliose = response.data.data || [];
        } else {
          response = await axios.get("/api/folios/folio", {
            params: {
              email: this.user.email,
              folio: this.folio,
            },
          });
          this.folios = response.data.data || [];
        }

        this.noFolios = !response.data.data.length;
      } catch (error) {
        console.error("Error al consultar el folio:", error);
      }
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
.custom-color {
  color: #002668;
}

.text-primary {
  color: #002668 !important;
}

.main-container {
  margin: 0 auto;
  max-width: 90%;
  padding: 15px;
}

.section-container {
  margin: 30px 0; /* Separación entre bloques */
  padding: 20px 0;
}

.shadow.rounded.bg-white {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Mejor sombra para destacar cada bloque */
}

.table-container {
  margin: 20px 0;
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
  align-items: center;
  gap: 15px;
}

.button-group {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.table-responsive {
  overflow-x: auto;
}

/* Fondo de página */
body {
  background: linear-gradient(to bottom right, #f7f8fa, #eaeff5); /* Fondo sutil para resaltar los bloques */
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
    flex-direction: column;
    gap: 10px;
  }
}
</style>
