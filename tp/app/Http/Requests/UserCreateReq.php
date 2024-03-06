<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>

    public function rules(): array
    {
        return [
            'name'=>'required|max:225',
            'email'=>'required|max:225',
            'clave'=>'clave|max:225',
            'id_rol'=>'required|exists:roles,id',
            'remember_token'
        ];
    }
}
