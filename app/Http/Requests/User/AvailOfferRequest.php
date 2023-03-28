<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AvailOfferRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'offer_id' =>'required',
            'vendor_code' => 'required|exists:users,code',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(api_validation_errors($validator->errors(),'Validation Errors'), 422);
        throw new ValidationException($validator, $response);
    }
}