import { createApp } from 'vue';
import App from './App.vue'; // Main component
import router from './route'; // Your Vue Router

const app = createApp(App);
app.use(router);
app.mount('#app'); // This should match the id in your Blade file
