import axios from 'axios'
window.axios = axios

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
const api = axios.create({
    baseURL: '/api',
    headers: {
        Accept: 'application/json',
    },
})

api.interceptors.request.use((config) => {

    const token = localStorage.getItem('token')

    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }

    return config
})

export default api
