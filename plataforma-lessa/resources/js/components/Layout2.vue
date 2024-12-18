<template>
    <div>
        <header>
            <nav>
                <ul>
        <li><a href="/inicio">Inicio</a></li>
        <li><a href="/consulta-informes">Consulta de Informes</a></li>
        <li><a href="/seguimiento-muestras">Seguimiento de Muestras</a></li>
      </ul>
            </nav>
        </header>
        <main>
            <slot></slot>
        </main>
        <footer>Este es el footer</footer>
    </div>
</template>

<script>
export default {
    name: "Layout",
};
</script>