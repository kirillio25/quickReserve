import { ref } from 'vue';
import { reserveTable } from '@/api/client/reservations';

export function useReservation(tables) {
    const selectedTableId = ref(null);
    const form = ref({ name: '', phone: '', notes: '' });
    const nameError = ref('');
    const phoneError = ref('');

    function openModal(id) {
        selectedTableId.value = id;
        form.value = { name: '', phone: '', notes: '' };
        nameError.value = '';
        phoneError.value = '';

        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('reserveModal'));
        modal.show();
    }

    function isValidPhone(phone) {
        return /^\+7\d{10}$/.test(phone);
    }

    async function submit() {
        nameError.value = '';
        phoneError.value = '';

        if (!form.value.name.trim()) {
            nameError.value = 'Укажите имя';
        }

        if (!form.value.phone.trim()) {
            phoneError.value = 'Укажите телефон';
        } else if (!isValidPhone(form.value.phone)) {
            phoneError.value = 'Телефон должен начинаться с +7 и содержать 11 цифр всего.';
        }

        if (nameError.value || phoneError.value) return;

        try {
            const response = await reserveTable(selectedTableId.value, {
                ...form.value,
                reserved_at: new Date().toISOString(),
                status: 1,
            });


            const table = tables.value.find(t => t.id === selectedTableId.value);
            if (table) table.is_reserved = true;

            bootstrap.Modal.getInstance(document.getElementById('reserveModal')).hide();

        } catch (err) {
            alert('Ошибка бронирования');
        }
    }

    return {
        selectedTableId,
        form,
        nameError,
        phoneError,
        openModal,
        submitReservation: submit,
    };
}
