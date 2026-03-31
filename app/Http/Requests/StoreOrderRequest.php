<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Base rules — field names MUST match the checkout form's input names
        $rules = [
            'name'           => ['required', 'string', 'min:2', 'max:100'],
            'email'          => ['required', 'email', 'max:150'],
            'phone'          => ['nullable', 'string', 'max:30'],
            'address'        => ['required', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'country'        => ['required', 'string', 'max:100'],
            'zip_code'       => ['nullable', 'string', 'max:20'],
            'payment_method' => ['required', 'in:cod,credit'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ];

        // Credit card fields — only required when credit method is selected
        if ($this->input('payment_method') === 'credit') {
            $rules['card_number'] = ['required', 'string', 'max:20'];
            $rules['card_expiry'] = ['required', 'string', 'max:7'];
            $rules['card_cvv']    = ['required', 'string', 'max:4'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Please enter your full name.',
            'email.required'          => 'Please enter a valid email address.',
            'address.required'        => 'Please enter your shipping address.',
            'city.required'           => 'Please enter your city.',
            'country.required'        => 'Please select your country.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in'       => 'Invalid payment method selected.',
        ];
    }
}
