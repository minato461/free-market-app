<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
            'password_confirmation.required' => '確認用パスワードを入力してください', // 確認用パスワードの未入力メッセージ
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password_confirmation.min' => 'パスワードは8文字以上で入力してください', // 確認用パスワードにも同じ min:8 メッセージを適用
            'password.confirmed' => 'パスワードと一致しません',
            'email.unique' => 'このメールアドレスは既に登録されています。',
        ];
    }
}