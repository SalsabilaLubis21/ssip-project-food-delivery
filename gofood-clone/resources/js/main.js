import { createApp } from "vue";
import App from "./App.vue";
import router from "./router"; // ✅ Pastikan router sudah diimpor

const app = createApp(App);
app.use(router); // ✅ Pastikan Vue menggunakan router
app.mount("#app");
