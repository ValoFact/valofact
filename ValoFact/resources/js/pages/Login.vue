<template>
    <div class="min-h-screen bg-gradient-to-b from-green-50 to-white">
      <Navbar />
      <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-green-800 mb-8">Login</h1>
        <form @submit.prevent="handleLogin">
          <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input
              v-model="email"
              type="email"
              id="email"
              class="w-full p-2 border border-gray-300 rounded"
              required
            />
          </div>
          <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input
              v-model="password"
              type="password"
              id="password"
              class="w-full p-2 border border-gray-300 rounded"
              required
            />
          </div>
          <button
            type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-all"
          >
            Login
          </button>
        </form>
      </div>
      <Footer />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useAuthStore } from '../stores/authStore';
  import Navbar from '../components/Navbar.vue';
  import Footer from '../components/Footer.vue';
  
  const email = ref('');
  const password = ref('');
  const authStore = useAuthStore();
  
  const handleLogin = async () => {
    try {
      await authStore.login(email.value, password.value);
    } catch (error) {
      alert('Login failed. Please check your credentials.');
    }
  };
  </script>