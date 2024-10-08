<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'id' => 'required|integer|exists:users,id',
            'name' => 'required|string|min:3|max:40',
            'surname' => 'required|string|min:3|max:40',
            'phone' => ['required', 'regex:/^\+7\d{10}$/i', Rule::unique('users', 'phone')->ignore($this->id)],
            'avatar' => 'required|image|mimes:jpg,png|max:2048',
        ];
    }
}
