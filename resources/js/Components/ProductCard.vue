<script setup>

defineProps({
    product: Object,
})

</script>

<template>

    <div class="bg-white rounded-xl shadow p-5">

        <h2 class="text-xl font-bold mb-2">
            {{ product.name }}
        </h2>

        <p class="text-gray-500 mb-3">
            {{ product.category?.name }}
        </p>

        <p class="mb-4">
            {{ product.description }}
        </p>

        <div class="flex justify-between items-center">

        <span class="font-bold text-lg">
            {{ product.price }} ₽
        </span>

            <a
                :href="`/product/${product.id}`"
                class="text-blue-500"
            >
                Подробнее
            </a>

        </div>

    </div>

</template>
