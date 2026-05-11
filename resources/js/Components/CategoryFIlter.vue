<script setup>
import { onMounted } from 'vue'
import { useCategories } from '@/composables/useCategories.js'

const props = defineProps({
    modelValue: {
        type: [Number, null],
        default: null,
    },
})

const emit = defineEmits(['update:modelValue'])

const { categories, fetchCategories } = useCategories()

onMounted(fetchCategories)
</script>

<template>
    <el-select
        :model-value="modelValue"
        placeholder="Категория"
        clearable
        class="w-64"
        @update:model-value="emit('update:modelValue', $event)"
    >
        <el-option
            v-for="category in categories"
            :key="category.id"
            :label="category.name"
            :value="category.id"
        />
    </el-select>
</template>
