<template>
    <div :key="route.fullPath">
        <!-- ✅ Memaksa Vue untuk merender ulang -->
        <div v-if="restaurant && restaurant.name">
            <!-- ✅ Pastikan `restaurant.name` ada sebelum ditampilkan -->
            <h1 class="text-xl font-bold">{{ restaurant.name }}</h1>
            <p class="text-gray-600">{{ restaurant.address }}</p>
            <p v-if="restaurant.phone" class="text-gray-500">
                📞 {{ restaurant.phone }}
            </p>
            <p
                v-if="restaurant.open_time && restaurant.close_time"
                class="text-gray-500"
            >
                🕒 {{ restaurant.open_time }} - {{ restaurant.close_time }}
            </p>

            <!-- 🔥 Debugging: Menampilkan seluruh data restoran -->
            <pre>{{ JSON.stringify(restaurant, null, 2) }}</pre>

            <h2 class="mt-4 text-lg font-semibold">🍽 Menu</h2>
            <div v-if="restaurant.menus && restaurant.menus.length > 0">
                <div
                    v-for="menu in restaurant.menus"
                    :key="menu.menu_id"
                    class="border p-4 mt-2"
                >
                    <h3>{{ menu.name }} - Rp{{ menu.price }}</h3>
                    <p v-if="menu.description">{{ menu.description }}</p>
                    <p v-if="menu.category_name" class="text-gray-500">
                        🍽 Kategori: {{ menu.category_name }}
                    </p>
                    <button
                        @click="addToCart(menu)"
                        class="bg-green-500 text-white px-3 py-1 rounded"
                    >
                        🛒 Pesan
                    </button>
                </div>
            </div>
            <p v-else class="text-red-500">🚨 Tidak ada menu tersedia!</p>
        </div>
        <p v-else class="text-red-500">🚨 Restoran tidak ditemukan!</p>
        <!-- ✅ Sekarang `v-else` langsung mengikuti `v-if` -->
    </div>
</template>

<script setup>
import { ref, watchEffect, nextTick } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";

const route = useRoute();
const restaurant = ref(null);

// ✅ Fungsi untuk mengambil data restoran berdasarkan ID
const fetchData = async () => {
    try {
        console.log("🔍 API Request: /api/restaurants/" + route.params.id);
        const response = await axios.get(`/api/restaurants/${route.params.id}`);
        restaurant.value = response.data;
        console.log("✅ Data restoran diterima:", restaurant.value);

        // ✅ Paksa Vue untuk merender ulang
        await nextTick();
    } catch (error) {
        console.error("🚨 Error mengambil data restoran!", error);
        restaurant.value = null;
    }
};

// ✅ Gunakan `watchEffect()` agar Vue selalu membaca perubahan ID restoran secara langsung
watchEffect(() => {
    console.log("🔄 ID restoran berubah, memuat data baru!");
    fetchData();
    instance?.proxy.$forceUpdate();
});
</script>
