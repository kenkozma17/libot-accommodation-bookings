<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryMovementRequest extends FormRequest
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
          'type' => 'required|string',
          'quantity' => 'required|numeric',
          'unit' => 'required|string',
          'previous_stock' => 'numeric',
          'current_stock' => 'numeric',
          'note' => 'nullable|string',
          'inventory_item_id' => 'required|numeric'
        ];
    }
}
