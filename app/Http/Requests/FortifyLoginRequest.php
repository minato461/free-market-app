<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as BaseLoginRequest;

class FortifyLoginRequest extends BaseLoginRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return (new LoginRequest())->rules();
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return (new LoginRequest())->messages();
    }
}