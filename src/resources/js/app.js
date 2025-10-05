import 'bootstrap/dist/css/bootstrap.min.css';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index.js';
import axios from './axiosInstance.js';

window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { restoreTokenAndUser } from './auth.js';

restoreTokenAndUser().then(user => {
    window.currentUser = user;

    const app = createApp(App);
    app.use(router);
    app.mount('#app');
});
