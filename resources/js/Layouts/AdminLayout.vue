<script setup>

import { useAuth } from '../composables/useAuth'
import { usePage } from '@inertiajs/vue3'
import {computed} from "vue";

const { logout } = useAuth()

const page = usePage()

const user = computed(() => page.props.auth.user)
</script>

<template>


    <div class="min-h-screen bg-gray-100">
        <div v-if="user">

        <header class="bg-white shadow">

            <div class="container mx-auto p-4 flex justify-between items-center">

                <h1 class="text-2xl font-bold">
                    Админ-панель
                </h1>

                <div class="flex gap-4 items-center">

                    <a
                        href="/admin/products"
                        class="text-blue-500"
                    >
                        Управление товарами
                    </a>

                    <button
                        class="text-red-500"
                        @click="logout"
                    >
                        Выйти
                    </button>

                </div>

            </div>

        </header>

        <main class="container mx-auto p-6">

            <slot />

        </main>
        </div>
        <div v-else>
            Not authenticated
        </div>
    </div>

</template>
