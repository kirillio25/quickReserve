<template>
    <div>
        <header data-bs-theme="dark">
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container d-flex justify-content-between align-items-center">
                    <a href="#" class="navbar-brand d-flex align-items-center">
                        <div class="d-flex align-items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-user me-2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <strong>Административная панель</strong>
                        </div>
                    </a>

                    <div class="d-flex align-items-center text-white" v-if="user">
                        <span class="me-3">{{ user.name }}</span>
                        <button @click="handleLogout" class="btn btn-outline-light btn-sm">Выйти</button>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="py-5 text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <h1 class="fw-light">Управление столиками</h1>
                        <p class="lead text-body-secondary">
                            Администратор может управлять столиками закрывать и отменять их. Так же бронировать для клиентов
                        </p>
                    </div>
                </div>
            </section>

            <section class="py-5 text-center container">
                <div class="row py-lg-5">


                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Название</th>
                                <th scope="col">Кол-во мест</th>
                                <th scope="col">Локация</th>
                                <th scope="col">Забронирован</th>
                                <th scope="col">Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="table in tables" :key="table.id">
                                <th scope="row">{{ table.id }}</th>
                                <td>{{ table.name }}</td>
                                <td>{{ table.seats }}</td>
                                <td>{{ table.location }}</td>
                                <td>{{ table.is_reserved ? 'Да' : 'Нет' }}</td>
                                <td>
                                    <div v-if="table.is_reserved">
                                        <button
                                            class="btn btn-sm btn-outline-danger" @click="cancelReservation(table.id)">Отмена</button>
                                        <button class="btn btn-sm btn-outline-success ms-1" @click="closeReservation(table.id)">Закрыть</button>
                                    </div>
                                    <div v-else>
                                        <button
                                            v-if="!table.is_reserved"
                                            @click="openModal(table.id)"
                                            type="button"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Забронировать
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            </section>
        </main>
    </div>


    <div class="modal fade" id="reserveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit.prevent="submitReservation">
                    <div class="modal-header">
                        <h5 class="modal-title">Бронирование</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" class="form-control" v-model="form.name" />
                            <div v-if="nameError" class="text-danger mt-1">{{ nameError }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Телефон</label>
                            <input type="text" class="form-control" v-model="form.phone" />
                            <div v-if="phoneError" class="text-danger mt-1">{{ phoneError }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Заметка</label>
                            <textarea class="form-control" v-model="form.notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Забронировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import * as bootstrap from 'bootstrap';
import { logout } from '../../auth.js';
import { fetchTables, closeTable, cancelTable, reserveTable } from '../../api/admin/reservations.js';
import { useReservation } from '../../composables/admin/useReservation.js';

const router = useRouter();
const user = ref(null);
const tables = ref([]);
const reserveModal = ref(null);
const selectedTableId = ref(null);

const {
    form,
    nameError,
    phoneError,
    openModal,
    submitReservation
} = useReservation(tables);

onMounted(async () => {
    user.value = window.currentUser;
    if (!user.value) return router.push('/admin/login');

    try {
        const res = await fetchTables();
        tables.value = res.data;
    } catch {
        router.push('/admin/login');
    }
});

async function handleLogout() {
    await logout();
    router.push('/admin/login');
}

async function closeReservation(id) {
    await closeTable(id);
    const index = tables.value.findIndex(t => t.id === id);
    if (index !== -1) tables.value[index].is_reserved = false;
}

async function cancelReservation(id) {
    await cancelTable(id);
    const index = tables.value.findIndex(t => t.id === id);
    if (index !== -1) tables.value[index].is_reserved = false;
}

</script>
