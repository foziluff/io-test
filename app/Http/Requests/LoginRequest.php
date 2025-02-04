<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class LoginRequest extends FormRequest
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
            'email'    => 'required|string|max:100',
            'password' => 'required|string|max:100'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $response = $this->expectsJson()
            ? new JsonResponse($validator->errors(), 422)
            : redirect()->back()->withErrors($validator)->withInput();

        throw new HttpResponseException($response);
    }

}
