<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Support\Facades\Redirect;
use  Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Persona;
use App\Http\Requests\PersonaCreateReq;
use Illuminate\Support\Facades\Log;


class AlumnoController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        $alumnos = Usuario::where('id_rol', 1)->with('persona')->paginate(10);
        return view('usuarios.alumnos.index', ['alumnos' => $alumnos]);
    }

    public function show($id)
    {
        $alumno = Persona::findOrFail($id);
        return view('alumnos.show', ['alumno'=>$alumno]);
    }
    
    public function create()
    {
        return view("usuarios.alumnos.create");
    }

    public function edit($id)
    {
        $alumno=Persona::with('usuario')->findOrFail($id);
        return view("usuarios.alumnos.edit",['alumno'=>$alumno]);
    }



    public function store(PersonaCreateReq $req)
    { 
        try {
            DB::beginTransaction();

            $newUsuario = Usuario::create([
                'email' => $req->input('email'),
                'clave' => $req->input('clave'),
                'nombre_usuario' => $req->input('nombre_usuario'),
                'id_rol' => 1,
            ]);


            $newPersona = Persona::create([
                'nombre' => $req->input('nombre'),
                'apellido' => $req->input('apellido'),
                'id_usuario' => $newUsuario->id
            ]);

            
            if ($newUsuario) {
                $newPersona = $newUsuario->persona;
            }

            DB::commit();
            return view("usuarios.alumnos.create");

        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el estudiante: ' . $exep->getMessage());
            return view("error.index");
        }
    }


        public function update(PersonaCreateReq $req, $id)
        {
            try{
                DB::beginTransaction();
                $alumno = Persona::where('id', $id)->with('usuario');
                $alumno->update(['nombre' => $req->input('nombre'),
                                'apellido' => $req->input('apellido')]);
                
 
                DB::commit();

                return view("usuarios.alumnos.edit",["alumno"=>$alumno]);
            }
            catch (\Exception $exep) {
                DB::rollBack();
                dd($exep->getMessage());
                Log::error('Error al crear el estudiante: ' . $exep->getMessage());
                return view("error.index");
            }
        }


        public function delete(Request $req)
        {
            try{
                DB::beginTransaction();
                $alumno = Persona::findOrFail($req->input('id'));
                $usuario = $alumno->usuario;
                $usuario->delete();
                $alumno->delete();
                DB::commit();
                return redirect('usuario/alumnos');

            
            }catch(\Exception $exep){
                DB::rollBack();
            }

        }
}
