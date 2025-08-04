<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('reserved_at')) {
            $this->merge([
                'reserved_at' => Carbon::parse($this->input('reserved_at'))->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^\+7\d{10}$/'],
            'notes' => 'nullable|string',
            'reserved_at' => 'required|date|after_or_equal:now',
            'status' => 'required|exists:reservation_statuses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Телефон должен начинаться с +7 и содержать 11 цифр всего.',
        ];
    }
}


