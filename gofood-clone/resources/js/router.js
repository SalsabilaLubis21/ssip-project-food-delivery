import { createRouter, createWebHistory } from "vue-router";
import Restaurants from "./Pages/Restaurants.vue";
import RestaurantDetail from "./Pages/RestaurantDetail.vue";

const routes = [
    { path: "/restaurants", component: Restaurants },
    { path: "/restaurants/:id", component: RestaurantDetail, props: true }, // ✅ Pastikan `props: true` agar ID dikirim ke komponen
    { path: "/:catchAll(.*)", redirect: "/restaurants" },
];

const router = createRouter({
    history: createWebHistory(), // ✅ Gunakan `createWebHistory()` agar navigasi tidak perlu refresh manual
    routes,
});

export default router;
