import './bootstrap';

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

import Alpine from 'alpinejs'


     




window.Alpine = Alpine;

Alpine.start();


import { useAuthStore } from './stores/authStore';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import api from './utils/api';
import '../css/app.css';

// Fetch CSRF token
api.get('/sanctum/csrf-cookie').then(() => {
  const app = createApp(App);
  const pinia = createPinia();
  app.use(pinia);
  app.use(router);

  app.mount('#app');
// Check authentication on app load
const authStore = useAuthStore();
authStore.checkAuth();
});
