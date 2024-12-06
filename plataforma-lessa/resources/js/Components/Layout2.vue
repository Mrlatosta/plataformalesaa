<template>
    <div>
        <header>
            <nav>
                <ul>
                    <li><a href="/inicio">Inicio</a></li>
                    <li><a href="/contacto">Contacto</a></li>
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