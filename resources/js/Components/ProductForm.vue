<script setup>

defineProps({
    form: Object,
    categories: Array,
    errors: Object,
    loading: Boolean,
})

const emit = defineEmits(['submit'])

</script>

<template>

    <el-form @submit.prevent="emit('submit')">

        <el-form-item
            label="Название"
            :error="errors.name?.[0]"
        >

            <el-input v-model="form.name" />

        </el-form-item>

        <el-form-item
            label="Категория"
            :error="errors.category_id?.[0]"
        >

            <el-select
                v-model="form.category_id"
                class="w-full"
            >

                <el-option
                    v-for="category in categories"
                    :key="category.id"
                    :label="category.name"
                    :value="category.id"
                />

            </el-select>

        </el-form-item>

        <el-form-item
            label="Описание"
            :error="errors.description?.[0]"
        >

            <el-input
                v-model="form.description"
                type="textarea"
                rows="5"
            />

        </el-form-item>

        <el-form-item
            label="Цена"
            :error="errors.price?.[0]"
        >

            <el-input-number
                v-model="form.price"
                :min="1"
                class="w-full"
            />

        </el-form-item>

        <el-button
            type="primary"
            :loading="loading"
            @click="emit('submit')"
        >
            Сохранить
        </el-button>

    </el-form>

</template>
