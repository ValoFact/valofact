<template>
    <nav class="bg-green-800 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <router-link to="/" class="text-2xl font-bold">ValoFact</router-link>
        <div class="space-x-4">
          <router-link to="/blog" class="hover:text-green-300">Blog</router-link>
          <router-link v-if="authStore.isAuthenticated" to="/orders" class="hover:text-green-300">Orders</router-link>
          <button v-if="authStore.isAuthenticated" @click="handleLogout" class="hover:text-green-300">Logout</button>
          <router-link v-else to="/login" class="hover:text-green-300">Login</router-link>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup>
  import { useAuthStore } from '../stores/authStore';
  import api from '../utils/api';
  import router from '../router';
  
  
  const authStore = useAuthStore();
  
  const handleLogout = async () => {
    try {
        // Fetch CSRF token first (required for Sanctum)
      await api.get('/sanctum/csrf-cookie');
      await authStore.logout();
    } catch (error) {
      console.error('Logout failed:', error.response?.data || error.message);
    }
  };
  console.log(authStore.isAuthenticated);
  
  </script>
