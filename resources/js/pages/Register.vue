<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-300 to-blue-500">
        <div
            class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 w-full max-w-sm"
        >
            <h1 class="text-gray-600 py-5 font-bold text-3xl text-center"> Crear cuenta </h1>
            <ul class="list-disc text-red-400 mb-4" v-if="errors.length > 0">
                <li v-for="(value, index) in errors" :key="index">{{ value[0] }}</li>
            </ul>
            <form method="post" @submit="handleSubmit">
                <div class="mb-4 mt-3">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="name"
                    >
                        Nombre
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker focus:outline-none focus:ring-2 focus:ring-blue-400"
                        id="name"
                        type="text"
                        required
                        v-model="form.name"
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="email"
                    >
                        Dirección de correo electrónico
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker focus:outline-none focus:ring-2 focus:ring-blue-400"
                        type="email"
                        id="email"
                        required
                        v-model="form.email"
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="password"
                    >
                        Contraseña
                    </label>
                    <input
                        class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        id="password"
                        type="password"
                        required
                        v-model="form.password"
                    />
                    <!-- <p class="text-red text-xs italic">Por favor elige una contraseña.</p> -->
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded w-full"
                        type="submit"
                    >
                        Registrarse
                    </button>
                </div>
            </form>
            <div class="text-center mt-4">
                <router-link
                    class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                    to="/"
                >
                    Iniciar sesión
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";

export default {
    setup() {
        const errors = ref([]);
        let router = useRouter();
        const form = reactive({
            name: '',
            email: '',
            password: '',
        });

        const handleSubmit = async (evt) => {
            evt.preventDefault();
            try {
                const result = await axios.post('/api/auth/register', form);
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token);
                    await router.push('home');
                }
            } catch (e) {
                if (e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors);
                }
            }
        };

        return {
            form,
            errors,
            handleSubmit,
        };
    }
}
</script>
