<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 to-blue-600">
        <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8">
            <h1 class="text-gray-800 py-4 font-semibold text-2xl text-center">Iniciar sesión</h1>
            <ul class="list-disc text-red-500" v-for="(value, index) in errors" :key="index" v-if="typeof errors === 'object'">
                <li>{{ value[0] }}</li>
            </ul>
            <p class="text-red-500" v-if="typeof errors === 'string'">{{ errors }}</p>
            <form method="post" @submit.prevent="handleLogin">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username">Dirección de correo electrónico</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="username"
                        type="text"
                        v-model="form.email"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password">Contraseña</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                    />
                </div>
                <div class="flex items-center justify-between mb-4">
                    <router-link class="text-blue-600 hover:underline" to="register">Registrarse</router-link>
                </div>
                <button
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded transition duration-200"
                    type="submit"
                >
                    Iniciar sesión
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";

export default {
    setup() {
        const errors = ref();
        const router = useRouter();
        const form = reactive({
            email: '',
            password: '',
        });

        const handleLogin = async () => {
            try {
                const result = await axios.post('/api/auth/login', form);
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token);
                    await router.push('home');
                }
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors);
                } else {
                    errors.value = e.response.data.message || "";
                }
            }
        };

        return {
            form,
            errors,
            handleLogin,
        };
    }
}
</script>
