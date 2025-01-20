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
use App\Mail\UploadWeeklyTrackingEmail;
use App\Mail\UploadFinalReportEmail;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('role_id', 1)->get();
        return view('users.students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.students.create');
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
                'role_id' => 1,
            ]);
            DB::commit();
            $students = User::where('role_id', 1)->get();
            return view('users.students.index', ['students' => $students]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el alumno: ' . $exep->getMessage());
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
        return view('users.students.edit', ['student' => User::findOrFail($id)]);
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
            $students = User::where('role_id', 1)->get();
            return view('users.students.index', ['students' => $students]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al crear el alumno: ' . $exep->getMessage());
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
            $students = User::where('role_id', 1)->get();
            return view('users.students.index', ['students' => $students]);
        } catch (\Exception $exep) {
            DB::rollBack();
            dd($exep->getMessage());
            Log::error('Error al eliminar el alumno: ' . $exep->getMessage());
            return view("error.index");
        }
    }

    public function saveFileWT(Request $request, $id)
    {
        try {
            $wt = WeeklyTracking::find($id);
            $pps = PPS::with('Student', 'Teacher')->findOrFail($wt->pps_id);
                
            $file = $request->file('file');
                
                if ($file && $file->isValid()) {
                    $content = file_get_contents($file->getRealPath());
                    $path = $file->storeAs('public/weekly_trackings', $file->getClientOriginalName());

                    $wt->file_path = $path;
                    $wt->save();

                    Mail::to($pps->Teacher->email)->send(
                        new UploadWeeklyTrackingEmail(
                            $pps->Student->last_name . ', ' . $pps->Student->first_name,
                            $pps->Student->email,
                            $pps->id,
                            $pps->Teacher->first_name
                        )
                    );

                    return redirect()->route('wt.details', ['id' => $wt->id]);
                    // ->with('success', 'Archivo cargado exitosamente.');
                }

            return response()->json(['success' => false]);
        } catch (\Exception $exep) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al guardar el archivo',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function saveFileFR(Request $request, $id)
    {
        try {
            $fr = FinalReport::find($id);
            $pps = PPS::with('Student', 'Teacher')->findOrFail($fr->pps_id);
            
            $file = $request->file('file');
            
            if ($file && $file->isValid()) {
                $content = file_get_contents($file->getRealPath());
                $path = $file->storeAs('public/final_report', $file->getClientOriginalName());

                $fr->file_path = $path;
                $fr->save();

                Mail::to($pps->Teacher->email)->send(
                    new UploadFinalReportEmail(
                        $pps->Student->last_name . ', ' . $pps->Student->first_name,
                        $pps->Student->email,
                        $pps->id,
                        $pps->Teacher->first_name
                    )
                );

                return redirect()->route('fr.details', ['id' => $fr->id])->with('success', 'Archivo cargado exitosamente.');
            }

            return response()->json(['success' => false]);
        } catch (\Exception $exep) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al guardar el archivo',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

}
