<template>
    <div>
        <!-- Header -->
        <header data-bs-theme="dark">
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <a href="#" class="navbar-brand d-flex align-items-center">
                        <div class="d-flex align-items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-calendar me-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <strong>Бронирование столиков</strong>
                        </div>
                    </a>

                    <a href="tel:+77001234567" class="text-white d-flex align-items-center text-decoration-none fs-5 me-3">
                        +7 (700) 123-45-67
                    </a>
                </div>
            </div>
        </header>


        <!-- Main Section -->
        <main>
            <section class="py-5 text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <h1 class="fw-light">Бронирование столиков</h1>
                        <p class="lead text-body-secondary">
                            Удобная система для просмотра и управления бронированием столиков в зале. Следите за статусами, планируйте размещение гостей и управляйте бронями в пару кликов.
                        </p>
                    </div>
                </div>
            </section>

            <div class="album py-5 bg-body-tertiary">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <div v-for="table in tables" :key="table.id" class="col">
                            <div class="card shadow-sm">
                                <img
                                    :src="'/storage/tables/tablePhoto.jpg'"
                                    class="bd-placeholder-img card-img-top"
                                    width="100%"
                                    height="225"
                                    alt="Table preview"
                                />

                                <div class="card-body">
                                    <h5 class="card-title">{{ table.name }} ({{ table.seats }} мест)</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button
                                                v-if="!table.is_reserved"
                                                @click="openModal(table.id)"
                                                type="button"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                Забронировать
                                            </button>
                                            <span v-else class="text-danger">Занят</span>
                                        </div>
                                        <small class="text-body-secondary">{{ table.location }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="text-body-secondary py-5">
            <div class="container">
                <p class="float-end mb-1"><a href="#">Наверх</a></p>
                <p class="mb-1">Система бронирования столиков. Разработано kirillio25 © 2025</p>
                <p class="mb-0">Используйте и адаптируйте под свои нужды — просто и удобно.</p>
            </div>
        </footer>

        <!-- Модальное окно -->
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
                                <input type="text" class="form-control" v-model="form.name"/>
                                <div v-if="nameError" class="text-danger mt-1">{{ nameError }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Телефон</label>
                                <input type="text" class="form-control" v-model="form.phone"/>
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
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { fetchTables } from '@/api/client/reservations';
import { useReservation } from '@/composables/client/useReservation';

const tables = ref([]);

const {
    selectedTableId,
    form,
    nameError,
    phoneError,
    openModal,
    submitReservation
} = useReservation(tables);

onMounted(async () => {
    const res = await fetchTables();
    tables.value = res.data;
});
</script>


