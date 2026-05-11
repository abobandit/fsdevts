import { ref } from 'vue'

import api from '../api/axios'

export function useProducts() {

    const meta = ref([])
    const products = ref([])
    const loading = ref(false)

    const fetchProducts = async (page = 1, category = null) => {
        loading.value = true
        const params = {
            page:page,
            category:category
        }
        try {
            const response = await api.get('/products', {
                params
            })
            meta.value = response.data
            products.value = meta.value.data

        } finally {

            loading.value = false
        }
    }

    const deleteProduct = async (id) => {

        await api.delete(`/products/${id}`)
    }

    return {
        products,
        loading,
        meta,
        fetchProducts,
        deleteProduct,
    }
}
