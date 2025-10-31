<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    use ApiResponseTrait;
    
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->notValid($validator->errors()->toArray(), 'Validation failed!'));
    }
}
