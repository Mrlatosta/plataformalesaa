<template>
 
    <div style="text-align: center;">
      <h2>Consulta de Informes</h2>
      <form @submit.prevent="consultarFolios">
        <div>
          <label for="fecha_inicio">Fecha Inicio:</label>
          <input type="date" v-model="fecha_inicio" required />
        </div>
        <div>
          <label for="fecha_fin">Fecha Fin:</label>
          <input type="date" v-model="fecha_fin" required />
        </div>
        <br>
        <button type="button" class="btn btn-outline-primary">Consultar</button>
      </form>

      <table class="table" v-if="folios.length">
        <thead>
          <tr>
            <th>Folio</th>
            <th>Fecha</th>
            <th>Descargar</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="folio in folios" :key="folio.folio">
            <td>{{ folio.folio }}</td>
            <td>{{ folio.fecha }}</td>
            <td>
              <button  type="button" class="btn btn-primary" @click="descargarFolio(folio)">Descargar</button>
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
        this.folios = response.data.data;
      } catch (error) {
        console.error("Error al consultar los folios:", error);
      }
    },
    descargarFolio(folio) {
      console.log(`Descargando folio ${folio.folio}`); // Implementar lógica de descarga
    },
  },
};
</script>

