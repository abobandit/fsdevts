import { ref } from 'vue'

import api from '../api/axios'

export function useCategories() {

    const categories = ref([])

    const fetchCategories = async () => {

        const response = await api.get('/categories')

        categories.value = response.data.data
    }

    return {
        categories,
        fetchCategories,
    }
}
