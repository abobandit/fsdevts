<script setup>
import { computed } from 'vue'

const props = defineProps({
    meta: Object,
})

const emit = defineEmits(['change'])

const pages = computed(() => {
    const total = props.meta?.last_page ?? 1
    const current = props.meta?.current_page ?? 1

    if (total < 1) return []

    const start = Math.max(1, current - 2)
    const end = Math.min(total, current + 2)

    const range = []
    for (let i = start; i <= end; i++) {
        range.push(i)
    }
    return range
})

const goTo = (page) => {
    emit('change', page)
}

</script>

<template>

    <div class="flex gap-2 mt-8 justify-center">

        <!-- prev -->
        <button
            class="px-3 py-1 border rounded disabled:opacity-40 disabled:cursor-not-allowed"
            :disabled="meta.current_page === 1"
            @click="goTo(meta.current_page - 1)"
        >
            Prev
        </button>

        <!-- pages -->
        <button
            v-for="p in pages"
            :key="p"
            @click="goTo(p)"
            class="px-3 py-1 border rounded"
            :class="{
            'bg-blue-500 text-white': p === meta.current_page
        }"
        >
            {{ p }}
        </button>

        <!-- next -->
        <button
            class="px-3 py-1 border rounded disabled:opacity-40 disabled:cursor-not-allowed"
            :disabled="meta.current_page === meta.last_page"
            @click="goTo(meta.current_page + 1)"
        >
            Next
        </button>

    </div>

</template>
