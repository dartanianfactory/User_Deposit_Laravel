<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class BalanceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Поле user_id обязательно для заполнения',
            'user_id.integer' => 'Поле должно быть целым числом',
        ];
    }
}
