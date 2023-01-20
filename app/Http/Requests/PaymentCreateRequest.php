<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PaymentCreateRequest extends FormRequest
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
            'debtId'     => 'required|integer',
            'paidAt'     => 'required|date_format:Y-m-d H:i:s',
            'paidAmount' => 'required|numeric|between:0,9999999999.99',
            'paidBy'     => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => __('api.required', ['attribute' => ':attribute']),
            '*.date_format' => __('api.date', ['attribute' => ':attribute']),
            '*.numeric' => __('api.numeric', ['attribute' => ':attribute']),
            '*.between' => __('api.between', ['attribute' => ':attribute', 'min' => ':min', 'max' => ':max']),
            '*.string' => __('api.string', ['attribute' => ':attribute']),
            '*.integer' => __('api.integer', ['attribute' => ':attribute']),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => __('api.invalid_parameters'),
            'data'      => $validator->errors()
        ], ResponseAlias::HTTP_BAD_REQUEST));
    }
}
