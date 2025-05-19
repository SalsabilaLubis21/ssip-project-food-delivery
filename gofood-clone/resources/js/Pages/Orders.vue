<template>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold text-gray-900">🛒 My Orders</h1>

        <!-- Tab Navigation -->
        <div class="flex mt-4 space-x-2">
            <button
                @click="activeTab = 'active'"
                :class="
                    activeTab === 'active'
                        ? 'bg-green-500 text-white'
                        : 'bg-gray-200'
                "
                class="px-4 py-2 rounded-lg"
            >
                📌 Active Orders
            </button>
            <button
                @click="activeTab = 'history'"
                :class="
                    activeTab === 'history'
                        ? 'bg-green-500 text-white'
                        : 'bg-gray-200'
                "
                class="px-4 py-2 rounded-lg"
            >
                📜 Order History
            </button>
        </div>

        <!-- Order List -->
        <div
            v-if="filteredOrders.length === 0"
            class="mt-6 text-gray-500 text-center"
        >
            🚀 No orders found!
        </div>

        <div v-else class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
                v-for="order in filteredOrders"
                :key="order.id"
                class="bg-white shadow-lg rounded-xl p-4"
            >
                <div class="flex justify-between">
                    <h2 class="text-lg font-semibold">Order #{{ order.id }}</h2>
                    <span
                        :class="getStatusClass(order.status)"
                        class="px-3 py-1 rounded-full text-white"
                    >
                        {{ order.status }}
                    </span>
                </div>
                <p class="text-gray-600 mt-2">
                    Total: Rp{{
                        new Intl.NumberFormat().format(order.payment_total)
                    }}
                </p>
                <p class="text-gray-400 text-sm">
                    📅 {{ formatDate(order.created_at) }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, computed } from "vue";

defineProps({
    orders: Array,
});

const activeTab = ref("active");

// Filter orders based on tab selection
const filteredOrders = computed(() => {
    return orders.filter((order) =>
        activeTab.value === "active"
            ? order.status !== "completed"
            : order.status === "completed"
    );
});

// Format Date
const formatDate = (date) => new Date(date).toLocaleDateString();

// Status Class Styling
const getStatusClass = (status) => {
    return status === "pending"
        ? "bg-yellow-500"
        : status === "processing"
        ? "bg-blue-500"
        : status === "completed"
        ? "bg-green-500"
        : "bg-gray-500";
};
</script>

<style scoped>
.container {
    max-width: 600px;
}
</style>
