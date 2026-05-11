<template>

    <div class="min-h-screen bg-gray-100">

        <header class="bg-white shadow">

            <div class="container mx-auto p-4 flex justify-between">

                <h1 class="text-2xl font-bold">
                    Каталог товаров
                </h1>

                <nav class="flex gap-4">

                    <a href="/" class="text-blue-500">
                        Главная
                    </a>

                    <a href="/login" class="text-blue-500">
                        Вход
                    </a>

                </nav>

            </div>

        </header>

        <main class="container mx-auto p-6">

            <slot />

        </main>

    </div>

</template>
