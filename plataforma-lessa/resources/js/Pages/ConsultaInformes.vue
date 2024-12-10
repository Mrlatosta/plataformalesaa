<template>
    <div>
      <h2>Consulta de Informes</h2>
      <form @submit.prevent="consultarFolios">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" v-model="fecha_inicio" required />
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" v-model="fecha_fin" required />
        <button type="submit">Consultar</button>
      </form>
      <table v-if="folios.length">
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
            <td><button>Descargar</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        fecha_inicio: "",
        fecha_fin: "",
        folios: [],
      };
    },
    methods: {
      async consultarFolios() {
        try {
          const response = await axios.get("/api/folios", {
            params: {
              fecha_inicio: this.fecha_inicio,
              fecha_fin: this.fecha_fin,
            },
          });
          this.folios = response.data.data;
        } catch (error) {
          console.error("Error al consultar los folios:", error);
        }
      },
    },
  };
  </script>
  