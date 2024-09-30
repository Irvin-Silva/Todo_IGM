<template>
    <div class="flex justify-end mb-4">
        <button
            class="px-4 py-2 text-white font-bold rounded-md transition"
            :class="sortAscending ? 'bg-blue-600' : 'bg-gray-500'"
            @click="toggleSortOrder"
        >
            {{ sortAscending ? 'Ordenar descendente' : 'Ordenar ascendente' }}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        sortAscending: Boolean,
    },
    methods: {
        toggleSortOrder() {
            this.$emit('toggleSortOrder');
        }
    }
}
</script>
