import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000', // Our Local API URL
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  withCredentials: true, // Required for Sanctum to send cookies
});

export default api;