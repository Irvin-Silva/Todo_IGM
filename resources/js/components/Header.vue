<template>
    <header class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800">Lista de tareas</h1>
        <div class="text-gray-600">
            Bienvenido {{ user && user.name }},
            <button class="text-blue-600 underline hover:no-underline" @click="$emit('logout')">Cerrar sesión</button>
        </div>
    </header>
</template>

<script>
export default {
    props: {
        user: Object,
    }
}
</script>
