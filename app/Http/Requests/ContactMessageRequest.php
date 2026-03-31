<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }
}
