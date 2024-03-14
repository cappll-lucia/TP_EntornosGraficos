<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaCreateReq extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
     
    public function rules(): array
    {
        return [
            'nombre'=>'required|max:225',
            'apellido'=>'required|max:225',
            'nombre_usuario'=>'required|max:225',
            'email'=>'required|max:225',
            'clave'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 225 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede tener más de 225 caracteres.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.max' => 'El nombre de usuario no puede tener más de 225 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.max' => 'El correo electrónico no puede tener más de 225 caracteres.',
            'clave.required' => 'La contraseña es obligatoria.',
        ];
    }
}
