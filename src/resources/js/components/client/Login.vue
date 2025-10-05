<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Вход в админку</h3>
                        <form @submit.prevent="handleLogin">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    v-model="email"
                                    type="email"
                                    id="email"
                                    class="form-control"
                                    placeholder="Введите email"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input
                                    v-model="password"
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Введите пароль"
                                    required
                                />
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import {login} from '../../auth.js';
import {useRouter} from 'vue-router';
import { restoreTokenAndUser } from '../../auth.js';


const email = ref('');
const password = ref('');
const router = useRouter();

async function handleLogin() {
    try {
        await login(email.value, password.value);
        const user = await restoreTokenAndUser();
        window.currentUser = user;
        router.push('/admin');
    } catch (error) {
        console.error('Login failed', error);
    }
}

</script>
