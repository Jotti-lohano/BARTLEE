<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditProfileRequest extends FormRequest
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
        $data = [
            // 'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
            // 'first_name' => 'required'
//            'bio' => 'required',
        ];

        // dd(auth('api')->user()->username, $this->username, strtolower($this->username) != strtolower(auth('api')->user()->username));
        // if(strtolower($this->username) != strtolower(auth('api')->user()->username)) {
        //     $data['username'] = 'required|unique:users';
        // }


        return $data;
    }
}
