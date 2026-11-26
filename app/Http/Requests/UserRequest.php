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
            'name' => 'min:1|max:100|required|regex:/^[a-zA-ZñÑáÁéÉíÍóÓúÚ][ñÑa-zA-Z áÁéÉíÍóÓúÚ]+$/',
            'email' =>  'email|required',
            'area' => 'required',
            'sit_carrera_id' => 'nullable|integer',
            'active' => 'required',
            'roles_id' => 'nullable|array',
            'roles_id.*' => 'integer|distinct|exists:roles,id',
            'password' => $this->routeIs('usuarios.store')
                ? 'required|min:4|max:60'
                : 'nullable|min:4|max:60',
            'password_confirmation' => $this->routeIs('usuarios.store')
                ? 'required_with:password|same:password|min:4|max:60'
                : 'nullable|required_with:password|same:password|min:4|max:60'
        ];
    }
}
