import axios from '../../axiosInstance';

export function fetchTables() {
    return axios.get('/api/tables');
}

export function reserveTable(tableId, data) {
    return axios.post(`/api/tables/${tableId}/reserve`, data);
}
