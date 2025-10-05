// auth.js
import axios from './axiosInstance.js';

export async function login(email, password) {
    await axios.get('/sanctum/csrf-cookie');
    const response = await axios.post('/api/admin/login', { email, password });
    localStorage.setItem('token', response.data.token);
    return response.data;
}

export async function getAdminData() {
    const response = await axios.get('/api/admin');
    return response.data;
}

export async function logout() {
    await axios.post('/api/admin/logout');
    localStorage.removeItem('token');
}

export async function restoreTokenAndUser() {
    const token = localStorage.getItem('token');
    if (!token) return null;

    try {
        const res = await axios.get('/api/admin/user');
        return res.data;
    } catch {
        localStorage.removeItem('token');
        return null;
    }
}
