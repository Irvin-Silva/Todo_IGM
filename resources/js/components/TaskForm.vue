<template>
    <section class="mb-6 p-4 bg-gray-100 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-2">{{ isEdit ? 'Editar tarea' : 'Agregar nueva tarea' }}</h2>
        <input 
            type="text" 
            class="p-3 border border-gray-300 rounded-md w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
            v-model="todo.title" 
            placeholder="Título de la tarea" 
        />
        <textarea 
            class="p-3 border border-gray-300 rounded-md w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
            v-model="todo.description" 
            placeholder="Descripción (opcional)"
        ></textarea>
        <input 
            type="text" 
            class="p-3 border border-gray-300 rounded-md w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
            v-model="todo.image" 
            placeholder="URL de la imagen (opcional)" 
        />
        <input 
            type="text" 
            class="p-3 border border-gray-300 rounded-md w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
            v-model="todo.tags" 
            placeholder="Etiquetas (separadas por comas)" 
        />
        <button 
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition" 
            @click="handleSubmit"
        >
            {{ isEdit ? 'Actualizar tarea' : 'Agregar tarea' }}
        </button>
    </section>
</template>

<script>
export default {
    props: {
        todo: Object,
        isEdit: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        handleSubmit() {
            this.$emit('submitTodo');
        }
    }
}
</script>
