<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'id' => 'required|integer|exists:comments,id',
            'user_id' => 'required|integer|exists:users,id,deleted_at,NULL', // в данном случае пользователь, который удален,
            'company_id' => 'required|integer|exists:companies,id,deleted_at,NULL', // не может редактировать комментарий
            'content' => 'required|string|min:150|max:550',                 // тоже в отношении удаленной компании
            'rating' => 'required|integer|between:1,10',
        ];
    }
}
