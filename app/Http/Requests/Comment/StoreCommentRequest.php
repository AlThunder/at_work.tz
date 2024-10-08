<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id,deleted_at,NULL',
            'company_id' => 'required|integer|exists:companies,id,deleted_at,NULL',
            'content' => 'required|string|min:150|max:550',
            'rating' => 'required|integer|between:1,10',
        ];
    }
}
