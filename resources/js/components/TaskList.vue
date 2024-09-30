<template>
    <ul class="space-y-4">
        <li
            v-for="(val, idx) in todos"
            :key="idx"
            class="flex flex-col p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-md transition hover:shadow-lg"
        >
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span 
                        :class="{'line-through text-gray-400': val.has_completed}" 
                        class="font-medium text-lg"
                    >
                        {{ val.title }}
                    </span>
                </div>
                <div>
                    <button
                        class="bg-green-500 px-2 text-white font-bold rounded-md hover:bg-green-600 transition mr-2"
                        @click="$emit('editTodo', val)"
                    >
                        Editar
                    </button>
                    <button
                        class="bg-red-500 px-2 text-white font-bold rounded-md hover:bg-red-600 transition"
                        @click="$emit('deleteTodo', val, idx)"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
            <div class="text-gray-600">
                {{ val.description }}
            </div>
            <div class="text-gray-400 text-sm">
                Fecha de creación: {{ new Date(val.created_at).toLocaleDateString() }}
            </div>
            <img v-if="val.image" :src="val.image" alt="Imagen de tarea" class="mt-2 rounded-md" />
            <div v-if="val.tags" class="mt-2">
                <span class="text-gray-600">Etiquetas: {{ val.tags }}</span>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        todos: Array
    }
}
</script>
