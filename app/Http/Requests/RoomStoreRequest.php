<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
          'name' => "required|string|max:50, {$this->id}",
          'rate' => 'required|numeric',
          'room_number' => 'required|string',
          'description' => 'nullable|string',
          'max_occupancy' => 'required|numeric',
          'is_available' => 'required|boolean',
          'status' => 'nullable|string',
          'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
          'size' => 'nullable|numeric',
          'floor' => 'nullable|numeric',
          'beds' => 'nullable|numeric',
        ];
    }
}
