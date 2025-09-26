<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'min_level' => 'required|numeric',
            'stock' => 'required|numeric',
            'est_cost' => 'required|numeric',
            'unit' => 'required|string',
            'description' => 'nullable',
            'inventory_category_id' => 'required'
        ];
    }
}
