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
            'name' => 'min:1|max:100|required|regex:/^[a-zA-ZñÑ][ñÑa-zA-Z ]+$/',
            'email' =>  'email|required',
            'area' => 'required',
            'active' => 'required',
            'password' => 'required|min:4|max:60',
            'password_confirmation' => 'required_with:password|same:password|min:4|max:60|required'
        ];
    }
}
