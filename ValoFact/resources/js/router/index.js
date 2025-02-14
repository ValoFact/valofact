import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Blog from '../pages/Blog.vue';
import BlogPostDetail from '../pages/BlogPostDetail.vue'; // For showing a specific blog post
import Orders from '../pages/Orders.vue';
import Login from '../pages/Login.vue';
import { useAuthStore } from '../stores/authStore';

const routes = [
  { path: '/', component: Home },
  { path: '/blog', component: Blog }, // List all blog posts
  { path: '/blog/:id', component: BlogPostDetail }, // Show a specific blog post
  { path: '/orders', component: Orders, meta: { requiresAuth: false } },
  { path: '/login', component: Login },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  await authStore.checkAuth(); // Ensure auth state is up-to-date

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login'); // Redirect to login if not authenticated
  } else {
    next();
  }
});

export default router;