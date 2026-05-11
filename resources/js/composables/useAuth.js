import { ref } from 'vue'

import api from '../api/axios'
import {router} from "@inertiajs/vue3";

const token = ref(localStorage.getItem('token'))
const user = ref(null)
const loading = ref(false)
export function useAuth() {
    const getCsrfCookie = async () => {
        await axios.get('/sanctum/csrf-cookie')
    }

    const login = async (form) => {
        await getCsrfCookie()

        // Manually read and decode the XSRF-TOKEN cookie
        const token = decodeURIComponent(
            document.cookie
                .split('; ')
                .find(row => row.startsWith('XSRF-TOKEN='))
                ?.split('=')[1] ?? ''
        )
        console.log('cookies after csrf call:', document.cookie)
        console.log('XSRF-TOKEN:', document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1])
        await axios.post('/login', form, {
            headers: { 'X-XSRF-TOKEN': token }
        })
    }

    const logout = async () => {
        await axios.post('/logout')
        router.visit('/login')
    }

    return { login, logout }
}
