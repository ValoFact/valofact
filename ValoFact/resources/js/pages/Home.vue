<template>
  <div class="min-h-screen bg-gradient-to-b from-green-50 to-white">
    <Navbar />
    <div class="container mx-auto p-4">
      <h1 class="text-4xl font-bold text-green-800 mb-8">Welcome to ValoFact</h1>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div v-for="post in posts" :key="post.id" class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
          <img v-if="post.blog_medias && post.blog_medias.length > 0" :src="post.blog_medias[0].mediaUrl" alt="Blog Post Image" class="w-full h-48 object-cover" />
          <div class="p-6">
            <h3 class="text-xl font-bold text-green-700">{{ post.title }}</h3>
            <p class="text-gray-600 mt-2">{{ post.content.substring(0, 100) }}...</p>
            <router-link :to="`/blog/${post.id}`" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-all">
              Read More
            </router-link>
          </div>
        </div>
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

const posts = ref([]);

onMounted(async () => {
  try {
    const response = await api.get('/api/blog-posts');
    posts.value = response.data;
  } catch (error) {
    console.error('Error fetching blog posts:', error);
  }
});
</script>