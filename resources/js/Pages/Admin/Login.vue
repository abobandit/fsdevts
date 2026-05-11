<script setup>

import { reactive, ref } from 'vue'

import { router } from '@inertiajs/vue3'

import { ElMessage } from 'element-plus'

import { useAuth } from '../../composables/useAuth'
import MainLayout from "@/Layouts/MainLayout.vue";

const { login } = useAuth()

const loading = ref(false)

const errors = ref({})

const form = reactive({
    email: '',
    password: '',
})

const submit = async () => {

    loading.value = true

    errors.value = {}

    try {
        await login(form)

        ElMessage.success('Успешный вход')

        router.visit('/admin/products')

    } catch (e) {

        if (e.response?.status === 422) {

            errors.value = e.response.data.errors
        }

        if (e.response?.status === 401) {

            ElMessage.error('Неверный логин или пароль')
        }

    } finally {

        loading.value = false
    }
}

</script>

<template>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <el-card class="w-full max-w-md">
            <a href="/" class="text-blue-500">
                Главная
            </a>
            <h1 class="text-2xl font-bold mb-6">
                Вход
            </h1>

            <el-form @submit.prevent="submit">

                <el-form-item
                    label="Email"
                    :error="errors.email?.[0]"
                >

                    <el-input v-model="form.email" />

                </el-form-item>

                <el-form-item
                    label="Пароль"
                    :error="errors.password?.[0]"
                >

                    <el-input
                        v-model="form.password"
                        type="password"
                        show-password
                    />

                </el-form-item>

                <el-button
                    type="primary"
                    class="w-full"
                    :loading="loading"
                    @click="submit"
                >
                    Войти
                </el-button>

            </el-form>

        </el-card>

    </div>

</template>
