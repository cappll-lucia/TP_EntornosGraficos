<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioCreateReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>

    public function rules(): array
    {
        return [
            'email'=>'required|max:225',
            'clave'=>'clave|max:225',
            'id_rol'=>'required|exists:roles,id',
            'remember_token'
        ];
    }
}
