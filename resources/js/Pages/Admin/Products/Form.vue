<script setup>

import { reactive, ref, onMounted } from 'vue'

import { router } from '@inertiajs/vue3'

import { ElMessage } from 'element-plus'

import api from '../../../api/axios'

import AdminLayout from '../../../Layouts/AdminLayout.vue'

import ProductForm from '../../../Components/ProductForm.vue'

import { useCategories } from '../../../composables/useCategories'

const props = defineProps({
    product: {
        type: Object,
        default: null,
    },
})

const form = reactive({
    name: props.product?.name || '',
    description: props.product?.description || '',
    price: props.product?.price || 1,
    category_id: props.product?.category_id || null,
})

const errors = ref({})

const loading = ref(false)

const { categories, fetchCategories } = useCategories()

onMounted(async () => {

    await fetchCategories()
})

const submit = async () => {

    loading.value = true

    errors.value = {}

    try {

        if (props.product) {

            await api.patch(`/products/${props.product.id}`, form)

        } else {

            await api.post('/products', form)
        }

        ElMessage.success('Сохранено')

        router.visit('/admin/products')

    } catch (e) {

        if (e.response?.status === 422) {

            errors.value = e.response.data.errors
        }

    } finally {

        loading.value = false
    }
}

</script>

<template>

    <AdminLayout>

        <div class="max-w-2xl">

            <h1 class="text-3xl font-bold mb-6">

                {{ product ? 'Редактирование' : 'Создание' }}

            </h1>

            <ProductForm
                :form="form"
                :categories="categories"
                :errors="errors"
                :loading="loading"
                @submit="submit"
            />

        </div>

    </AdminLayout>

</template>
