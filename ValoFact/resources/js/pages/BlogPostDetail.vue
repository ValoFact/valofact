<template>
  <div class="min-h-screen bg-gradient-to-b from-green-50 to-white">
    <Navbar />
    <div class="container mx-auto p-4">
      <h1 class="text-4xl font-bold text-green-800 mb-8">{{ post.title }}</h1>
      <img
        v-if="post.blog_medias && post.blog_medias.length > 0"
        :src="post.blog_medias[0].mediaUrl"
        alt="Blog Post Image"
        class="w-full h-64 object-cover mb-8"
      />
      <p class="text-gray-600">{{ post.content }}</p>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import api from '../utils/api';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

const route = useRoute();
const post = ref({});


onMounted(async () => {
  try {
    const response = await api.get(`/api/blog-posts/${route.params.id}`);
    post.value = response.data;
  } catch (error) {
    console.error('Error fetching blog post:', error);
  }
});
</script>