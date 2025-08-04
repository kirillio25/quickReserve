import { ref } from 'vue';
import axios from '../../axiosInstance.js';

export function useReservation(tables) {
    const form = ref({ name: '', phone: '', notes: '' });
    const nameError = ref('');
    const phoneError = ref('');
    const selectedTableId = ref(null);
    const modalRef = ref(null);

    function isValidPhone(phone) {
        return /^\+7\d{10}$/.test(phone);
    }

    function openModal(id) {
        selectedTableId.value = id;
        form.value = { name: '', phone: '', notes: '' };
        nameError.value = '';
        phoneError.value = '';

        const modalElement = document.getElementById('reserveModal');
        if (modalElement) {
            modalRef.value = bootstrap.Modal.getOrCreateInstance(modalElement);
            modalRef.value.show();
        }
    }

    async function submitReservation() {
        nameError.value = '';
        phoneError.value = '';

        if (!form.value.name.trim()) nameError.value = 'Укажите имя';
        if (!form.value.phone.trim()) {
            phoneError.value = 'Укажите телефон';
        } else if (!isValidPhone(form.value.phone)) {
            phoneError.value = 'Телефон должен начинаться с +7 и содержать 11 цифр всего.';
        }

        if (nameError.value || phoneError.value) return;

        try {
            await axios.post(`/api/tables/${selectedTableId.value}/reserve`, {
                ...form.value,
                reserved_at: new Date().toISOString(),
                status: 1,
            });

            const index = tables.value.findIndex(t => t.id === selectedTableId.value);
            if (index !== -1) tables.value[index].is_reserved = true;

            if (modalRef.value) modalRef.value.hide();
        } catch (error) {
            console.error('Ошибка при бронировании:', error);
            alert('Не удалось забронировать столик');
        }
    }

    return {
        form,
        nameError,
        phoneError,
        openModal,
        submitReservation,
    };
}
