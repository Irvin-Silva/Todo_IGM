<template>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <Header :user="user" @logout="handleLogout" />

        <TaskForm :todo="currentTodo" :isEdit="isEdit" @submitTodo="handleTodoSubmit" />

        <TaskSort :sortAscending="sortAscending" @toggleSortOrder="toggleSortOrder" />

        <TaskList :todos="sortedTodos" @editTodo="editTodo" @deleteTodo="deleteTodo" />
    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from "vue-router";
import { request } from '../helper';
import Header from '../components/Header.vue';
import TaskForm from '../components/TaskForm.vue';
import TaskSort from '../components/TaskSort.vue';
import TaskList from '../components/TaskList.vue';

export default {
    components: {
        Header,
        TaskForm,
        TaskSort,
        TaskList,
    },
    setup() {
        const currentTodo = ref({
            title: '',
            description: '',
            created_at: new Date().toISOString().split('T')[0],
            image: '',
            tags: ''
        });
        const todos = ref([]);
        const user = ref();
        const isLoading = ref(false);
        const sortAscending = ref(true);
        const isEdit = ref(false);

        const router = useRouter();
        onMounted(() => {
            authentication();
            handleTodos();
        });

        const authentication = async () => {
            isLoading.value = true;
            try {
                const req = await request('get', '/api/user');
                user.value = req.data;
            } catch (e) {
                await router.push('/');
            }
            isLoading.value = false;
        }

        const handleTodos = async () => {
            try {
                const req = await request('get', '/api/todos');
                todos.value = req.data.data;
            } catch (e) {
                await router.push('/');
            }
            isLoading.value = false;
        }

        const handleNewTodo = async () => {
            isLoading.value = true; // Inicia el loading al comenzar la operación
            try {
                const req = await request('post', '/api/todos', currentTodo.value);
                if (req.data.message) {
                    return alert(req.data.message);
                }
                todos.value.push(req.data.data); 
                resetForm();
            } catch (e) {
                await router.push('/');
            }
            await handleTodos(); 
            isLoading.value = false;
        }

        const handleEditTodo = async () => {
            isLoading.value = true; 
            try {
                const req = await request('put', `/api/todos/${currentTodo.value.id}`, currentTodo.value);
                if (req.data.message) {
                    return alert(req.data.message);
                }
                const index = todos.value.findIndex(todo => todo.id === currentTodo.value.id);
                if (index !== -1) {
                    todos.value[index] = req.data.data; // Actualiza la tarea existente
                }
                resetForm();
            } catch (e) {
                await router.push('/');
            }
            await handleTodos(); 
            isLoading.value = false;
        }

        const resetForm = () => {
            currentTodo.value = { title: '', description: '', created_at: new Date().toISOString().split('T')[0], image: '', tags: '' };
            isEdit.value = false;
        }

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN');
            router.push('/');
        }

        const handleTodoSubmit = () => {
            if (currentTodo.value.title === "") {
                return alert("El título de la tarea no puede estar vacío");
            }
            if (isEdit.value) {
                handleEditTodo(); 
            } else {
                handleNewTodo(); 
            }
        }

        const editTodo = (todo) => {
            currentTodo.value = { ...todo };
            isEdit.value = true;
        }

        const deleteTodo = async (val, index) => {
            if (window.confirm("¿Estás seguro?")) {
                try {
                    const req = await request('delete', `/api/todos/${val.id}`);
                    if (req.data.message) {
                        todos.value.splice(index, 1);
                    }
                } catch (e) {
                    await router.push('/');
                }
            }
            await handleTodos(); 
        }

        const toggleSortOrder = () => {
            sortAscending.value = !sortAscending.value;
        }

        const sortedTodos = computed(() => {
            return todos.value.slice().sort((a, b) => {
                return sortAscending.value 
                    ? new Date(a.created_at) - new Date(b.created_at) 
                    : new Date(b.created_at) - new Date(a.created_at);
            });
        });

        return {
            currentTodo,
            todos,
            user,
            editTodo,
            handleTodoSubmit,
            isLoading,
            deleteTodo,
            handleLogout,
            toggleSortOrder,
            sortedTodos,
            sortAscending,
            isEdit
        }
    },
}
</script>

<style scoped>
.line-through {
    text-decoration: line-through;
}
</style>
