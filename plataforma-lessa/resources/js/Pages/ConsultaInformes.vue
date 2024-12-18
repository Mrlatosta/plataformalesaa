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
            <button type="button" class="btn btn-primary" @click="descargarFolio(user.email, folio.folio)"><img src="../../../public/downloadicon.png" style="filter: invert(100%);"  width="20" alt="Decargar"></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<<<<<<< HEAD


=======
>>>>>>> 225d3b7b760bab78b2a1298bf9dbd5ac55a7b3f5
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
      noFolios: false, // Nueva variable para controlar la visualización del mensaje
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

    // Método para descargar un archivo asociado al folio
    async descargarFolio(userEmail,folio) {
  try {
    // Obtener el token desde localStorage
    const token = localStorage.getItem('authToken'); // Asumiendo que el token se guarda bajo la clave 'token'

    if (!token) {
      console.error('Token no disponible');
      return; // Salir si no hay token
    }

    console.log('Pase el token' + token);

    // Llamar a la API para obtener la URL temporal del archivo
    const response = await axios.get(`/api/file-url/${userEmail}/${folio}`, {
      headers: {
        'Authorization': `Bearer ${token}` // Usar el token de localStorage
      }
    });

    console.log('Pase la response',response);
    console.log('Url del archivo',response.data.url);

    const fileData = response.data.data; // data contiene file_name y url
    const fileName = fileData.file_name;
    const fileUrl = fileData.url;

    // Si la URL del archivo es exitosa, proceder a descargar
    const url = fileUrl;

    console.log('URL temporal del archivo:', url);


    // Crear un enlace dinámico para la descarga
    const link = document.createElement('a');
    link.href = url;
    link.download = folio; // Nombre del archivo a descargar
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

/* Estilo del mensaje de error centrado */
.no-folios-alert {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  padding: 15px;
  width: 100%;
  text-align: center;
  font-size: 1rem;
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

  .table {
    width: 100%;
    font-size: 0.8rem;
  }
}
</style>
