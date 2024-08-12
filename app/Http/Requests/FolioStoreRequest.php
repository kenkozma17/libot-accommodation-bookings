<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FolioStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'guest_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'guest_id.required' => 'A guest is required.',
        ];
    }
}
