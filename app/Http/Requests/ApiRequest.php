<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $this->convert_array_message($validator->errors()->toArray());
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    private function convert_array_message($arrayMessage): array
    {
        $errors = [];
        foreach ($arrayMessage as $val) {
            foreach ($val as $value) {
                $errors[] = $value;
            }
        }
        return array_unique($errors);
    }
}
