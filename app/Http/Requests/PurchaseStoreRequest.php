<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseStoreRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを行う権限があるかどうかを判断します。
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // 認証済みのユーザーであれば購入を許可
        // ログイン状態を確認し、認証されていれば true を返します。
        return auth()->check();
    }

    /**
     * リクエストに適用されるバリデーションルールを取得します。
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // 現時点では、最低限のエラー解消のために空の配列を返します。
        // 実際には、支払い方法や配送先情報など、購入に必要なパラメータのバリデーションルールをここに記述します。
        return [
            // 'payment_method_id' => ['required', 'exists:payment_methods,id'],
            // 'address_id' => ['required', 'exists:addresses,id'],
        ];
    }

    /**
     * バリデーションエラーメッセージを定義します。
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            // バリデーションルールに対応するカスタムエラーメッセージを記述します
        ];
    }
}