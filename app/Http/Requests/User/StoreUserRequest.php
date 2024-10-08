<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:40',
            'surname' => 'required|string|min:3|max:40',
            'phone' => 'required|unique:users|regex:/^\+7\d{10}$/i',
            'avatar' => 'required|image|mimes:jpg,png|max:2048'
        ];
    }
}
