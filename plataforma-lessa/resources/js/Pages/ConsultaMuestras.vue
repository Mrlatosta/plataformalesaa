 <template>
    <div class="shadow rounded bg-white m-xl-3 m-5 p-xl-5 p-2 position-relative">
      <div class="image-container">
        <!-- Imagen posicionada arriba del texto -->
        <img src="../../../public/gota.png" alt="Gota" class="gota-image" />
      </div>
      <h2 style="text-align: center;">Consulta de Muestras</h2>
      <hr>
      <div style="text-align: center;">
        <form @submit.prevent="consultarMuestras">
          <!-- Contenedor de rango de fechas -->
          <div class="form-container">
            <div>
              <label for="folio_muestreo">Folio de muestreo:</label>
              <input type="text" v-model="folio_muestreo" required />
            </div>
          </div>
  
          <br />
          <button type="button" class="btn btn-outline-primary" @click="consultarMuestras">Consultar</button>
        </form>
        
    </div>
      <table class="table" v-if="muestras.length" style="text-align: center;">
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
            <th>estatus</th>        
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
      };
    },
    methods: {
      async consultarMuestras() {
        if (!this.user || !this.user.email) {
          console.error("El usuario no está definido o no tiene un email:", this.user);
          return;
        }
  
        try {
          const response = await axios.get("/api/muestras", {
            params: {
              email: this.user.email,
              folio: this.folio_muestreo,
            },
          });
          this.muestras = response.data.data;
        } catch (error) {
          console.error("Error al consultar los folios:", error);
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
  
  /* Contenedor de fechas */
  .form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 30px; /* Asegura que las fechas no se solapen con la imagen */
  }
  
  /* Media query para pantallas pequeñas */
  @media (max-width: 767px) {
    /* Asegura que la imagen esté centrada y encima del texto */
    .image-container {
      flex-direction: column;
      align-items: center;
    }
    
    .gota-image {
      width: 80px; /* Reducir el tamaño de la imagen en móvil */
      margin-bottom: 15px; /* Espacio entre la imagen y el texto */
    }
  
    /* El texto de la cabecera debería estar centrado */
    h2 {
      margin-top: 10px;
    }
  }
  </style>
  