<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Support\Facades\Redirect;
use DB;
use App\Models\User;
use App\Models\Persona;
use App\Http\Requests\PersonaCreateReq;
use Illuminate\Support\Facades\Log;


class StudentController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        $students = User::where('id_rol', 1)->with('Person')->get();
        return view('users.students.index', ['students'=>[]]);
    }

    public function show($id)
    {
        $student = Persona::findOrFail($id);
        return view('students.show', ['student'=>$student]);
    }
    
    public function create()
    {
        return view("users.students.create");
    }

    public function edit($id)
    {
        return view("users.students.edit");
        // return view("users.students.edit",["user"=>User::findOrFail($id)]);
    }

public function store(PersonaCreateReq $req)
{ 
    try {
        DB::beginTransaction();

        $newUser = User::create([
            'email' => $req->input('email'),
            'clave' => $req->input('clave'),
            'name' => $req->input('nombre'),
            'id_rol' => 1,
        ]);


        Persona::create([
            'nombre' => $req->input('nombre'),
            'apellido' => $req->input('apellido'),
            'id_usuario' => $newUser->id
        ]);

        $newUser = User::where('email', $req->input('email'))->with('Persona')->first();

        DB::commit();
        return view("users.students.create");

    } catch (\Exception $exep) {
        DB::rollBack();
        dd($exep->getMessage()); // Agregar esta línea para imprimir el mensaje de error
        Log::error('Error al crear el estudiante: ' . $exep->getMessage());
        return view("error.index");
    }
}


    public function update()
    {

    }


    public function delete(Request $req)
    {
        try{
            DB::beginTransaction();
            $student = Person::findOrFail($req->input('id'));
            $user = $student->User;
            $user->delete();
            $student->delete();
            return Redirect::to('users/students');

        DB::commit();
        }catch(\Exception $exep){
             DB::rollBack();
        }

    }
}
