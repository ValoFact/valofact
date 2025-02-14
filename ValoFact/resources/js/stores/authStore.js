import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '../utils/api';
import router from '../router';

export const useAuthStore = defineStore('auth', () => {
  const isAuthenticated = ref(false);
  const user = ref(null);

  // Check if the user is authenticated
  const checkAuth = async () => {
    try {
      const response = await api.get('/api/user', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        }
      }); // Protected endpoint
      user.value = response.data;
      isAuthenticated.value = true;
    } catch (error) {
      isAuthenticated.value = false;
      user.value = null;
    }
  };

  // Login
  const login = async (email, password) => {
    try {
      await api.get('/sanctum/csrf-cookie'); // Fetch CSRF token
      const response = await api.post('/api/login', { email, password });
      console.log(response.data);
      localStorage.setItem('authToken', response.data.token);
      user.value = response.data.user;
      isAuthenticated.value = true;
      router.push('/'); // Redirect to home after login
    } catch (error) {
      console.error('Login failed:', error);
      throw error; // Re-throw the error for the component to handle
    }
  };

  // Logout
  const logout = async () => {
    try {
      await api.post('/api/logout', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        }
      });
      isAuthenticated.value = false;
      user.value = null;
    } catch (error) {
      console.error('Logout failed:', error);
    }
  };

  return {
    isAuthenticated,
    user,
    checkAuth,
    login,
    logout,
  };
});