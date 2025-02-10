<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => "required|email",
            'phone' => 'required',
            'nationality' => 'required|string',
            'total_price' => 'required|numeric',
            'booking_confirmation' => '',
            'booking_date' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'rate_per_night' => 'required|numeric',
            'adults_count' => 'required|numeric',
            'children_count' => 'required|numeric',
            'booking_status' => 'required',
            'room_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => 'The room is required.',
        ];
    }
}
