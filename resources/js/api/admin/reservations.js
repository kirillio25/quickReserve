import axios from '../../axiosInstance.js';

export function fetchTables() {
    return axios.get('/api/admin');
}

export function closeTable(id) {
    return axios.post(`/api/admin/tables/${id}/close`);
}

export function cancelTable(id) {
    return axios.post(`/api/admin/tables/${id}/cancel`);
}

export function reserveTable(id, data) {
    return axios.post(`/api/tables/${id}/reserve`, data);
}

