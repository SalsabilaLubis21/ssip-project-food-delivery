<template>
    <div>
        <h1>🍽 Daftar Restoran</h1>

        <!-- 🔥 Debugging: Menampilkan data JSON -->
        <pre v-if="props.restaurants">{{
            JSON.stringify(props.restaurants, null, 2)
        }}</pre>

        <div
            v-if="props.restaurants?.data && props.restaurants.data.length > 0"
        >
            <div
                v-for="restaurant in props.restaurants.data"
                :key="restaurant.restaurant_id"
                class="border p-4 mt-2"
            >
                <h3>{{ restaurant.name }}</h3>
                <p>{{ restaurant.address }}</p>

                <!-- ✅ Navigasi ke halaman detail dengan `router.replace()` -->
                <button
                    @click="navigateToRestaurant(restaurant.restaurant_id)"
                    class="bg-blue-500 text-white px-3 py-1 rounded"
                >
                    🏡 View Details
                </button>
            </div>

            <!-- ✅ Pagination -->
            <div class="mt-4 flex space-x-2">
                <button
                    v-if="props.restaurants.prev_page_url"
                    @click="goToPage(props.restaurants.prev_page_url)"
                    class="bg-gray-300 px-4 py-2 rounded"
                >
                    &laquo; Previous
                </button>
                <button
                    v-if="props.restaurants.next_page_url"
                    @click="goToPage(props.restaurants.next_page_url)"
                    class="bg-gray-300 px-4 py-2 rounded"
                >
                    Next &raquo;
                </button>
            </div>
        </div>

        <p v-else class="text-red-500">🚨 Tidak ada restoran yang ditemukan!</p>
    </div>
</template>

<script setup>
import { defineProps, nextTick } from "vue"; // ✅ Perbaiki! Impor `nextTick` dari Vue, bukan Vue Router
import { useRouter } from "vue-router";

const props = defineProps({
    restaurants: Object, // ✅ Pastikan Vue menerima `restaurants` sebagai Object
});

const router = useRouter();

// ✅ Fungsi untuk navigasi ke halaman detail restoran tanpa perlu refresh
const navigateToRestaurant = async (restaurantId) => {
    console.log("🔄 Navigasi ke restoran ID:", restaurantId);
    await nextTick(); // ✅ Paksa Vue untuk merender ulang sebelum navigasi
    router.push(`/restaurants/${restaurantId}`);
};

// ✅ Fungsi untuk navigasi halaman berikutnya
const goToPage = (url) => {
    const page = new URL(url).searchParams.get("page");
    router.push(`/restaurants?page=${page}`);
};

// 🔥 Debugging: Log data dari Laravel untuk memastikan Vue menerima informasi
console.log("Daftar Restoran:", props.restaurants);
console.log("Data Restoran:", props.restaurants?.data);
</script>
