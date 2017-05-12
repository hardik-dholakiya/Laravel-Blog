<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'oldPassword' => 'required|min:6|different:newPassword|alpha_dash',
            'newPassword' => 'required|min:6|same:confirm-password|alpha_dash',
            'confirm-password' => 'required|min:6|alpha_dash'
        ];
    }
}
