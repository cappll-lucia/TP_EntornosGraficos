<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\PPS;
use Illuminate\Support\Facades\Mail;
use App\Mail\AssignTeacherEmail;
use App\Models\FinalReport;
use App\Mail\FinishPPSEmail;
use Illuminate\Validation\Rule;
use App\Mail\NotifyTeacherEmail;


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

            $validatedData = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'legajo' => ['required', 'numeric'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'legajo' => $validatedData['legajo'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => 3,
            ]);
            DB::commit();
            $responsibles = User::where('role_id', 3)->get();
            return view('users.responsibles.index', ['responsibles' => $responsibles]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Error al crear el responsable: ' . $ex->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el rsponsable. Inténtelo de nuevo.')->withInput();
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
            $emailRule = ['required', 'string', 'lowercase', 'email', 'max:255'];
            if ($user->email !== $request->email) {
                $emailRule[] = Rule::unique('users', 'email');
            }
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'legajo' => ['required', 'numeric'],
                'email' => $emailRule,
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el responsable: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();

            $responsibles = User::where('role_id', 3)->get();
            return redirect()->route('getResponsibles')->with([
                'responsibles' => $responsibles,
                'success' => 'Responsable eliminado correctamente'
            ]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al eliminar el responsable: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    public function assignTeacher(Request $request, $id)
    {
        try {
            $pps = PPS::with('Student')->findOrFail($id);
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

            Mail::to($pps->Student->email)->send(
                new AssignTeacherEmail(
                    $pps->Student->first_name,
                    $teacher->last_name . ', ' . $teacher->first_name,
                    $teacher->email
                )
            );

            Mail::to($teacher->email)->send(
                new AssignTeacherEmail(
                    $teacher->first_name,
                    $pps->Student->last_name . ', ' . $pps->Student->first_name,
                    $pps->Responsible->email
                )
            );

            $pps->update([
                'teacher_id' => $teacher->id,
                'is_finished' => 1,
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Finalizado',
                'message' => 'Has asignado el docente correctamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al tomar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function finishWholePPS($id)
    {
        try {
            $pps = PPS::with('Teacher', 'Student', 'Responsible')->findOrFail($id);
            $fr = FinalReport::where('pps_id', $pps->id)->first();
            $teacher = User::findOrFail($pps->teacher_id);

            if ($fr->is_accepted == false) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al finalizar el proceso de PPS',
                    'message' => 'El reporte final aún no ha sido aceptado',
                ], 400);
            }
            if (auth()->user()->role_id != 3) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al asignar el docente',
                    'message' => 'El usuario no es un responsable',
                ], 400);
            }

            Mail::to($pps->Teacher->email)->send(
                new FinishPPSEmail(
                    $pps->Student->first_name . ', ' . $pps->Student->last_name,
                    $teacher->first_name,
                    $pps->id,
                    $pps->Responsible->email
                )
            );

            Mail::to($pps->Student->email)->send(
                new FinishPPSEmail(
                    $pps->Student->first_name . ', ' . $pps->Student->last_name,
                    $teacher->first_name,
                    $pps->id,
                    $pps->Responsible->email
                )
            );

            $fr->update([
                'is_checked' => true,
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Finalizado',
                'message' => 'Has finalizado el proceso de PPS correctamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al tomar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
