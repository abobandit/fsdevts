<script setup>

import {onMounted, ref, watch} from 'vue'

import MainLayout from '../../Layouts/MainLayout.vue'

import ProductCard from '../../Components/ProductCard.vue'
import CategoryFilter from '../../Components/CategoryFIlter.vue'

import Pagination from '../../Components/Pagination.vue'

import {useProducts} from '../../composables/useProducts'

const page = ref(1)

const {products, meta, fetchProducts} = useProducts()

const selectedCategory = ref(null)
const load = async (p = 1) => {

    page.value = p

    await fetchProducts(p,selectedCategory.value)
}

onMounted(async () => {
    await load()
})

watch(page, (newPage) => {
    load(newPage)
})
watch(selectedCategory, () => {
    load()
})
</script>

<template>

    <MainLayout>
        <div class="mb-6">
            <CategoryFilter v-model="selectedCategory"/>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />

        </div>

        <Pagination
            v-if="meta"
            :meta="meta"
            @change="load"
        />

    </MainLayout>

</template>
