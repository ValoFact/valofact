<template>
  <div class="min-h-screen bg-gradient-to-b from-green-50 to-white">
    <Navbar />
    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
      <img :src="image" alt="Nature" class="w-full h-48 object-cover" />
      <div class="p-6">
        <h3 class="text-xl font-bold text-green-700">{{ title }}</h3>
        <p class="text-gray-600 mt-2">{{ description }}</p>
        <button
          class="mt-4 bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-all"
          @click="onClick"
        >
          Learn More
        </button>
      </div>
    </div>
    <Footer />
  </div>
</template>
  
  <script setup>

  import { ref, onMounted } from 'vue';
  import api from '../utils/api';
  import Navbar from '../components/Navbar.vue';
  import Footer from '../components/Footer.vue';

  const orders = ref([]);
  
  onMounted(async () => {
    try {
      const response = await api.get('/api/orders');
      orders.value = response.data;
    } catch (error) {
      console.error('Error fetching orders:', error);
    }
  });

  

  defineProps({
    title: String,
    description: String,
    image: String,
    onClick: Function,
  });
  </script>