<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
            'id' => 'required|integer|exists:companies,id',
            'name' => ['required', 'string', 'min:3', 'max:40', Rule::unique('companies', 'name')->ignore($this->id)],
            'description' => 'required|string|min:150|max:400',
            'logo' => 'required|image|mimes:png|max:3072',
        ];
    }
}
