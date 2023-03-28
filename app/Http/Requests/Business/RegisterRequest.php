<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'account_details.username' => 'required|unique:users,username',
            'account_details.email' => 'required|unique:users,email',
            'account_details.password' => 'required',
            'additional_info.account_category' => 'required',
            'additional_info.business_type' => 'required',
            'additional_info.phone' => 'required|unique:users,phone',
            'verification_info' => 'required',
            'verification_info.verification_type' => 'required|in:mail,phone',
            'verification_info.code' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'account_details.username' => 'username',
            'account_details.email' => 'email',
            'account_details.password' => 'password',
            'additional_info.account_category' => 'account category',
            'additional_info.business_type' => 'business type',
            'additional_info.phone' => 'phone',
        ];
    }
}
