document.addEventListener('DOMContentLoaded', function() {
    const carouselText = document.getElementById('carousel-text');
    const carouselLink = document.getElementById('carousel-link');
    const carouselSubtext = document.getElementById('carousel-subtext'); // Obtiene el elemento del subtítulo

    const slides = [
        { 
            text: "Laboratorio de análisis de agua y alimentos"
        },
        {
            text: "Análisis Microbiologicos"
        },
        {
            text: "Análisis Fisicoquimicos"
        },
        {
            text: "Cursos de Distintivo H"
        },
        // {
        //     text: "Ingeniería Industrial",
        //     link: "https://www.unicaribe.mx/licenciaturas/ingenieria-industrial"
        // },
        // {
        //     text: "Ingeniería en Inteligencia Artificial",
        //     link: "https://www.unicaribe.mx/licenciaturas/ingenieria-inteligencia-artificial"
        // },
        // {
        //     text: "Ingeniería en Industrias Alimentarias",
        //     link: "https://www.unicaribe.mx/licenciaturas/ingenieria-industrias-alimentarias"
        // }
    ];
    
    const slideSubtexts = [
        "Profesionales con ética y responsabilidad | Analisis Microbiológicos y Fisicoquímicos",
        "Análisis de indicadores y patogenos",
        "Análisis de calidad y contaminantes",
        "Estandar de manejo higiénico de alimentos",
    ];

    const updateCarouselText = (event) => {
        const activeItemIndex = event ? event.to : 0;
        const slide = slides[activeItemIndex]; // Obtiene la diapositiva activa del arreglo

        // Actualiza el texto del título y del subtítulo
        carouselText.textContent = slide.text;
        carouselLink.href = slide.link;
        carouselSubtext.textContent = slideSubtexts[activeItemIndex];
    };

    // Inicializar el texto para la primera carga
    updateCarouselText();

    // Añadir listener para el evento de cambio de diapositiva
    $('#carrusel_principal').on('slide.bs.carousel', updateCarouselText);
});
