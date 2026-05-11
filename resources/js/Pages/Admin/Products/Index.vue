<script setup>

import {onMounted, ref, watch} from 'vue'

import AdminLayout from '../../../Layouts/AdminLayout.vue'

import Pagination from '../../../Components/Pagination.vue'

import { useProducts } from '../../../composables/useProducts'

import api from '../../../api/axios'

import { ElMessageBox, ElMessage } from 'element-plus'
import MainLayout from "@/Layouts/MainLayout.vue";
import CategoryFilter from "@/Components/CategoryFIlter.vue";

const page = ref(1)

const loading = ref(false)

const { products, meta, fetchProducts } = useProducts()

const selectedCategory = ref(null)
// загрузка страницы
const load = async (p = 1) => {

    loading.value = true

    page.value = p

    await fetchProducts(p,selectedCategory.value)

    loading.value = false
}

// стартовая загрузка
onMounted(() => {
    load(1)
})

// удаление товара
const remove = async (id) => {

    try {

        await ElMessageBox.confirm(
            'Удалить товар?',
            'Подтверждение',
            {
                type: 'warning',
            }
        )

        await api.delete(`/products/${id}`)

        ElMessage.success('Удалено')

        load(page.value) // 🔥 остаёмся на той же странице

    } catch (e) {
        // cancel ignore
    }
}

watch(selectedCategory, () => {
    load()
})
</script>

<template>

    <AdminLayout>

        <!-- HEADER -->
        <div class="flex justify-between mb-6">

            <h1 class="text-3xl font-bold">
                Товары
            </h1>

            <el-button
                type="primary"
                @click="$inertia.visit('/admin/products/create')"
            >
                Добавить
            </el-button>

        </div>

        <!-- TABLE -->

        <div class="mb-6">
            <CategoryFilter v-model="selectedCategory"/>
        </div>
        <el-table
            :data="products"
            v-loading="loading"
            class="w-full"
        >

            <el-table-column
                prop="id"
                label="ID"
                width="80"
            />

            <el-table-column
                prop="name"
                label="Название"
            />

            <el-table-column
                prop="category.name"
                label="Категория"
            />

            <el-table-column
                prop="price"
                label="Цена"
            />

            <el-table-column label="Действия" width="220">

                <template #default="{ row }">

                    <div class="flex gap-2">

                        <el-button
                            size="small"
                            type="primary"
                            @click="$inertia.visit(`/admin/products/${row.id}/edit`)"
                        >
                            Редактировать
                        </el-button>

                        <el-button
                            size="small"
                            type="danger"
                            @click="remove(row.id)"
                        >
                            Удалить
                        </el-button>

                    </div>

                </template>

            </el-table-column>

        </el-table>

        <!-- PAGINATION -->
        <div class="mt-6 flex justify-center">

            <Pagination
                v-if="meta"
                :meta="meta"
                @change="load"
            />

        </div>

    </AdminLayout>

</template>
