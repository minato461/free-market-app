<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentStoreRequest extends FormRequest
{
    /**
     */
    public function authorize(): bool
    {
        // ログインユーザーのみ許可
        return Auth::check();
    }

    /**
     */
    public function rules(): array
    {
        return [
            'comment' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     */
    public function messages(): array
    {
        return [
            'comment.required' => 'コメントは必ず入力してください。',
            'comment.max' => 'コメントは255文字以内で入力してください。',
        ];
    }
}
