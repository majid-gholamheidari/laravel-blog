<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:150',
            'password' => 'required|string|min:6'
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator) {
        $response =  Response::json([
            'success' => false,
            'data' => ['errors' => $validator->errors()->all()],
            'message' => 'Invalid credentials! try again.',
        ], 422);
        throw new HttpResponseException($response);
    }
}
