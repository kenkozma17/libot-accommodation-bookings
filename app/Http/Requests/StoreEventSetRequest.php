<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventSetRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|unique:event_sets',
            'type' => 'required|string',
            'notes' => 'nullable|string'
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $itemId = $this->event_set;
            $rules['name'] = 'required|string|unique:event_sets,name,' . $itemId;
        }

        return $rules;
    }
}
