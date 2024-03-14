<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Support\Facades\Redirect;
use  Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Persona;
use App\Http\Requests\PersonaCreateReq;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    public function index(){
        $teachers = User::where('id_rol', 2)->with('persona')->paginate(10);
        #return view('users.teachers.index', ['teachers' => $teachers]);
    }

    public function show($id){
        $teacher = Persona::FindOrFail($id);
        #return view('users.teachers.show', ['teacher' => $teacher]);
    }

    public function create(){
        return view('users.teachers.create');
    }

    public function edit(){
        #return view('users.teachers.edit', ['teacher' => User::findOrFail($id)]);
    }

    public function store(PersonaCreateReq $req){
        try{
            DB::beginTransaction();
            
            $newUser = User::create([
                'email' => $req->input('email'),
                'clave' => $req->input('clave'),
                'name' => $req->input('nombre'),
                'id_rol' => 2
            ]);

            $newPersona = Persona::create([
                'nombre' =>$req->input('nombre'),
                'apellido' =>$req->input('apellido'),
                'id_usuario' => $newUser->id
            ]);

            $newUser = User::where('email', $req->input('email'))->with('persona')->first();

            if ($newUser) {
                $persona = $newUser->persona;
            }

            DB::commit();
            return view('users.teachers.create');

        }  catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el docente: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    public function delete(Request $req)
    {
        try{
            DB::beginTransaction();
            $student = Persona::findOrFail($req->input('id'));
            $user = $student->User;
            $user->delete();
            $student->delete();
            DB::commit();
            return redirect('users/teachers');

        
        }catch(\Exception $exep){
             DB::rollBack();
        }

    }
}
