<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\PPS;

class ResponsiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responsibles = User::where('role_id', 3)->get();
        return view('users.responsibles.index', ['responsibles' => $responsibles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.responsibles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'legajo' => ['required', 'numeric'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'legajo' => $request->legajo,
                'password' => Hash::make($request->password),
                'role_id' => 3,
            ]);
            DB::commit();
            $responsibles = User::where('role_id', 3)->get();
            return view('users.responsibles.index', ['responsibles' => $responsibles]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el responsable: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('users.responsibles.edit', ['responsible' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'legajo' => ['required', 'numeric'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            ]);
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'legajo' => $request->legajo,
            ]);
            DB::commit();
            $responsibles = User::where('role_id', 3)->get();
            return view('users.responsibles.index', ['responsibles' => $responsibles]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el alumno: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    public function assignTeacher(Request $request, $id) {
        try {
            $pps = PPS::findOrFail($id);
            $teacher = User::findOrFail($request->input('selectedTeacher'));

            if ($pps->is_finished == 1) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al asignar el docente',
                    'message' => 'La solicitud ya fue finalizada',
                ], 400);
            }
            if (auth()->user()->role_id != 3) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al asignar el docente',
                    'message' => 'El usuario no es un responsable',
                ], 400);
            }
            // Mail::to($pps->Student->email)->send(new AssignTeacherEmail($pps->Student->name, $teacher->lastname . ', ' . $teacher->name, $teacher->User->email));
            $pps->update([
                'teacher_id' => $teacher->id,
                'is_finished' => 1,
            ]);
            
            return redirect()->route('pps.details', ['id' => $pps->id])->with('success', 'Docente asignado correctamente');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al tomar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
