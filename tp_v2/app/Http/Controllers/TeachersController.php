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
use App\Models\FinalReport;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovePPSEmail;
use App\Mail\ApproveWeeklyTrackingEmail;
use App\Mail\ApproveFinalReportEmail;
use App\Mail\RejectPPSEmail;

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
            ], 500);
        }
    }

    public function approvePps(Request $request, $id) {
        try {
            $pps = PPS::with('Student', 'Teacher')->findOrFail($id);
    
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
    
            if ($pps->is_finished == 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'La solicitud no está finalizada',
                ], 400);
            }
    
            $pps->update([
                'is_approved' => 1,
            ]);
    
            Mail::to($pps->Student->email)->send(
                new ApprovePPSEmail(
                    $pps->Student->first_name,
                    $pps->id,
                    $pps->Teacher->email
                )
            );
    
            return response()->json([
                'success' => true,
                'title' => 'PPS aprobada con éxito',
                'message' => 'Se notificó al estudiante.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al aprobar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectPps(Request $request, $id) {
        try {
            $pps = PPS::with('Student', 'Teacher')->findOrFail($id);
    
            if (auth()->user()->role_id != 2 || $pps->teacher_id != auth()->user()->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al rechazar la solicitud',
                    'message' => 'No tiene permisos para rechazar esta solicitud',
                ], 403);
            }
    
            $pps->update([
                'is_finished' => 0,
                'is_approved' => 0,
            ]);
    
            Mail::to($pps->Student->email)->send(
                new RejectPPSEmail(
                    $pps->Student->first_name,
                    $pps->id,
                    $pps->observation,
                    $pps->Teacher->email,
                )
            );
    
            return response()->json([
                'success' => true,
                'message' => 'Solicitud rechazada correctamente. El estudiante ha sido notificado.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al rechazar la solicitud',
                'message' => 'Ocurrió un error. Intente nuevamente.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        

    public function editObservationWT(Request $request, $id)
    {
        try {
            $wt = WeeklyTracking::findOrFail($id);
            $wt->observation = $request->input('observation');
            $wt->save();

            return redirect()->back()->with('success', 'Observación guardada con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al editar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approveWT(Request $request, $id)
    {
        try {
            $wt = WeeklyTracking::findOrFail($id);
            $pps = PPS::with('Student', 'Teacher')->findOrFail($wt->pps_id);

            if ($wt->id == $pps->weeklyTrackings()->first()->id) {
                $wt->update([
                    'is_accepted' => 1,
                ]);
                
                return redirect()->route('wt.details', ['id' => $pps->id])->with('success', 'Semana aprobada correctamente.');
            }

            $previousWT = $pps->weeklyTrackings()->where('id', '<', $wt->id)->orderBy('id', 'desc')->first();

            if ($previousWT && !$previousWT->is_accepted) {
                return redirect()->route('wt.details', ['id' => $wt->id])->with('error', 'No se puede aprobar este seguimiento, ya que el anterior no está aprobado.');
            }

            $wt->update([
                'is_accepted' => 1,
            ]);

            Mail::to($pps->Student->email)->send(
                new ApproveWeeklyTrackingEmail(
                    $pps->Student->first_name,
                    $pps->id,
                    $pps->Teacher->email
                )
            );

            return redirect()->route('wt.details', ['id' => $wt->id])->with('success', 'Semana aprobada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al aprobar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 600);
        }
    }

    public function editObservationFR(Request $request, $id)
    {
        try {
            $fr = FinalReport::findOrFail($id);
            $fr->observation = $request->input('observation');
            $fr->save();

            return redirect()->back()->with('success', 'Observación guardada con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al aprobar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 600);
        }
        
    }

    public function approveFR(Request $request, $id)
    {
        try {
            $fr = FinalReport::findOrFail($id);
            $pps = PPS::with('Student', 'Teacher')->findOrFail($fr->pps_id);

            if (auth()->user()->role_id != 2) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'El usuario no es un profesor',
                ], 600);
            }

            if (auth()->user()->role_id == 2 && $pps->teacher_id != auth()->user()->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'No tiene permisos para aprobar la solicitud',
                ], 600);
            }

            $fr->update([
                'is_accepted' => 1,
            ]);

            Mail::to($pps->Student->email)->send(
                new ApproveFinalReportEmail(
                    $pps->Student->first_name,
                    $pps->id,
                    $pps->Teacher->email
                )
            );

            return redirect()->route('fr.details', ['id' => $pps->id])->with('success', 'Reporte final aprobado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al aprobar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 600);
        }
    }

}
