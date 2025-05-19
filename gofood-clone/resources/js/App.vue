<template>
    <InertiaApp />
    <!-- ✅ Gantilah `router-view` dengan `InertiaApp` -->
</template>

<script setup>
import { createInertiaApp } from "@inertiajs/vue3"; // ✅ Pastikan Inertia diimpor dengan benar

createInertiaApp({
    resolve: (name) => import(`./Pages/${name}.vue`), // 🔥 Pastikan Vue membaca halaman dari Inertia
    setup({ el, App, props }) {
        createApp(App).mount(el); // ✅ Pastikan Vue benar-benar dipasang ke #app
    },
});
</script>
