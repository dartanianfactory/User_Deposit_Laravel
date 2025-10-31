<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class DepositRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to_user_id' => 'required|integer|min:1',
            'amount' => 'required|decimal:2|min:0.01',
            'comment' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'to_user_id.required' => 'Поле user_id обязательно для заполнения',
            'to_user_id.integer' => 'Поле должно быть целым числом',
            'amount.required' => 'Поле amount обязательно для заполнения',
            'amount.decimal' => 'Поле должно быть числом с плавающей запятой. 0.01 пример',
        ];
    }
}
