<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\PPS;
use App\Models\WeeklyTracking;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = User::where('role_id', 2)->get();
        return view('users.teachers.index', ['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.teachers.create');
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
                'role_id' => 2,
            ]);
            DB::commit();
            $teachers = User::where('role_id', 2)->get();
            return view('users.teachers.index', ['teachers' => $teachers]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el docente: ' . $exep->getMessage());
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
        return view('users.teachers.edit', ['teacher' => User::findOrFail($id)]);
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
            $teachers = User::where('role_id', 2)->get();
            return view('users.teachers.index', ['teachers' => $teachers]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el docente: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            $teachers = User::where('role_id', 2)->get();
            return view('users.teachers.index', ['teachers' => $teachers]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al eliminar el docente: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    public function editObservationPPS(Request $request, $id) {
        try {
            $pps = PPS::findOrFail($id);

            if (auth()->user()->role_id == 2 && $pps->teacher_id == auth()->user()->id) {
                $pps->observation = $request->input('observation');
                $pps->save();

                return redirect()->back()->with('success', 'Observación guardada con éxito');
            }

            return redirect()->back()->with('error', 'No tienes permisos para agregar observaciones');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al editar la observación',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function approvePps(Request $request, $id) {
        try {
            $pps = PPS::findOrFail($id);

            if (auth()->user()->role_id != 2) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'El usuario no es un profesor',
                ], 400);
            }
            if (auth()->user()->role_id == 2 && $pps->teacher_id != auth()->user()->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'No tiene permisos para aprobar la solicitud',
                ], 400);
            }
            if ($pps->is_finished === 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'La solicitud no está finalizada',
                ], 400);
            }

            $pps->update([
                'is_approved' => 1,
            ]);

            // Mail::to($application->Student->User->email)->send(
            //     new ApproveApplicationEmail(
            //         $application->Student->name,
            //         $application->id,
            //         $application->Teacher->User->email
            //     )
            // );

            return redirect()->route('pps.details', ['id' => $pps->id])->with('success', 'PPS aprobada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al aprobar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function editObservationWT(Request $request, $id)
    {
        $wt = WeeklyTracking::findOrFail($id);
        $wt->observation = $request->input('observation');
        $wt->save();

        return redirect()->back()->with('success', 'Observación guardada con éxito');
    }

    public function approveWT(Request $request, $id)
    {
        $wt = WeeklyTracking::findOrFail($id);
        $pps = $wt->pps;

        if ($wt->id == $pps->weeklyTrackings()->first()->id) {
            $wt->is_accepted = true;
            $wt->save();
            
            return redirect()->route('wt.details', ['id' => $wt->id])->with('success', 'Semana aprobada correctamente.');
        }

        $previousWT = $pps->weeklyTrackings()->where('id', '<', $wt->id)->orderBy('id', 'desc')->first();

        if ($previousWT && !$previousWT->is_accepted) {
            return redirect()->route('wt.details', ['id' => $wt->id])->with('error', 'No se puede aprobar este seguimiento, ya que el anterior no está aprobado.');
        }

        $wt->is_accepted = true;
        $wt->save();

        return redirect()->route('wt.details', ['id' => $wt->id])->with('success', 'Semana aprobada correctamente.');

        // Version original (sin validar que la wt esté aprobada)
        // try {
        //     $wt = WeeklyTracking::findOrFail($request->input('id'))->load('PPS');
        //     $pps = $wt->PPS;

        //     if (auth()->user()->role_id != 2 || $pps->teacher_id != auth()->user()->id) {
        //         return response()->json([
        //             'success' => false,
        //             'title' => 'Error al aceptar el seguimiento',
        //             'message' => 'No está autorizado a realizar esta acción'
        //         ], 400);
        //     }
    
        //     $wt->is_accepted = true;
        //     $wt->save();
    
        //     // Enviar el correo si es necesario
        //     /*Mail::to($pps->Student->User->email)->send(
        //         new ApproveWeeklyTrackingEmail(
        //             $pps->Student->name,
        //             $pps->id,
        //             $pps->Teacher->User->email
        //         )
        //     );*/
    
        //     return redirect()->route('wt.approve', ['id' => $wt->id])->with('success', 'Seguimiento aprobado correctamente');
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'title' => 'Error al aceptar el seguimiento',
        //         'message' => 'Intente nuevamente o comuníquese para soporte',
        //         'error' => $e->getMessage()
        //     ], 400);
        // }
    }

}
