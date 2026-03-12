<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
            'username' => 'sometimes|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'country' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'postal_code' => 'sometimes|string|max:20',
            'birthdate' => 'sometimes|date',
            'bio' => 'sometimes|string',
            'avatar_url' => 'sometimes|url',
        ];
    }
}
