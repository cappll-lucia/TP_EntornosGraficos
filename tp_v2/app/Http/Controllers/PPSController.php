<?php

namespace App\Http\Controllers;

use App\Http\Requests\PPS\PPSCreateRequest;
use App\Http\Requests\PPS\PPSUpdateRequest;
use App\Models\PPS;
use App\Models\User;
use App\Models\WeeklyTracking;
use App\Models\WorkPlan;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Dompdf\Dompdf;
use Dompdf\Options;
use DomPDF\Facade as PDF;

class PPSController extends Controller
{
    public function index()
    {
        try {
            $rol = auth()->user()->role_id;
            switch ($rol) {
                case 1:
                    $pps = PPS::where('student_id', auth()->user()->id)->get();
                    break;


                case 2:
                    $pps = PPS::where('teacher_id', auth()->user()->id)->whereNotNull('responsible_id')->get();
                    break;

                case 3:
                    $pps = PPS::all();
                    break;

                case 4:
                    $pps = PPS::all();
                    break;

                default:
                    $pps = [];
                    break;
            }
            return view('pps.index', compact('pps'));
        } catch (\Exception $e) {
            $error = new \stdClass();
            $error->code = 500;
            $error->message = 'Error al cargar la página';
            return view('error', compact('error'));
        }
    }

    public function new()
    {
        try {
            $user = User::where('id', auth()->user()->id)->first();
            if ($user->role_id != 1) {
                $error = new \stdClass();
                $error->code = 403;
                $error->message = 'Para poder crear una solicitud deber ser un estudiante';
                return view('error', compact('error'));
            }
            $student = User::where('email', $user->email)->first();

            $all_teachers = User::where('role_id', 2)->get();
            $teachers = [];
            foreach ($all_teachers as $teach) {
                $cant_pps = PPS::where('teacher_id', $teach->id)->where('is_finished', 0)->count();
                if ($cant_pps <= 10) {
                    $teachers[] = $teach;
                }
            }
            return view('pps.new', ['student' => $user, 'teachers' => $teachers]);
        } catch (\Exception $e) {
            $error = new \stdClass();
            $error->code = 500;
            $error->message = 'Error al cargar la página';
            return view('error', compact('error'));
        }
    }

    public function details($id)
    {
        try {
            $pps = PPS::with('Student', 'Responsible', 'WorkPlan', 'FinalReport')->findOrFail($id);

            $user = User::where('id', auth()->user()->id)->first();
            $wp = WorkPlan::where('pps_id', $pps->id)->first();
            $wts = $pps->WeeklyTrackings()->exists();

            if (
                ($user->role_id == 1 && $user->id != $pps->student_id) || ($user->role_id == 2 && $user->id != $pps->teacher_id)

            ) {
                $error = new \stdClass();
                $error->code = 403;
                $error->message = 'No está autorizado a ver esta solicitud';
                return view('error', compact('error'));
            }
            $teachers = [];
            if ($pps->responsible_id != null) {

                $all_teachers = User::where('role_id', 2)->get();
                $teachers = [];
                foreach ($all_teachers as $teach) {
                    $cant_pps = PPS::where('teacher_id', $teach->id)->where('is_finished', 0)->count();
                    if ($cant_pps <= 10) {
                        $teachers[] = $teach;
                    }
                }
            }

            return view('pps.details', compact('pps', 'teachers', 'wp', 'wts'));
        } catch (\Exception $e) {
            $error = new \stdClass();
            $error->code = 500;
            $error->message = 'Error al cargar la página';
            return view('error', compact('error'));
        }
    }

    public function create(Request $request)
    {
        // TODO: Enviar mail a responsable
        $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        try {
            $student = User::where('id', auth()->user()->id)->first();
            if ($student == null) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al crear la solicitud',
                    'message' => 'El estudiante no existe'
                ], 400);
            }
            // Crear una fecha de inicio y finalización

            $dateFrom = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $dateTo = Carbon::createFromFormat('Y-m-d', $request->input('finish_date'));

            if ($dateFrom > $dateTo) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al crear la solicitud',
                    'message' => 'La fecha de inicio no puede ser mayor a la fecha de finalización'
                ], 400);
            }
            DB::beginTransaction();
            $pps = PPS::create([
                'student_id' => $student->id,
                'start_date' => $request->input('start_date'),
                'finish_date' => $request->input('finish_date'),
                'description' => $request->input('description'),
                'is_finished' => 0,
                'is_approved' => 0,
                'teacher_id' => $request->input('teacher_id'),
                // 'created_at' => $today,
                // 'updated_at' => ''
            ]);

            $file = $request->file('file');

            if ($file && $file->isValid()) {
                $content = file_get_contents($file->getRealPath());
                $path = $file->storeAs('public/work_plan', $file->getClientOriginalName());
                WorkPlan::create([
                    'pps_id' => $pps->id,
                    'file_path' => $path,
                    'is_accepted' => 0
                ]);
            } else {

            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud creada correctamente',
                'data' => $pps
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al crear la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));

        try {
            $pps = PPS::findOrFail($id);

            $dateFrom = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $dateTo = Carbon::createFromFormat('Y-m-d', $request->input('finish_date'));

            if ($dateFrom > $dateTo) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al actualizar la solicitud',
                    'message' => 'La fecha de inicio no puede ser mayor a la fecha de finalización'
                ], 400);
            }

            DB::beginTransaction();

            $pps->start_date = $request->input('start_date');
            $pps->finish_date = $request->input('finish_date');
            $pps->description = $request->input('description');
            $pps->is_editable = false;
            $pps->save();

            $file = $request->file('file');
            if ($file && $file->isValid()) {
                // Eliminar archivo anterior si existe
                if ($pps->WorkPlan) {
                    Storage::delete($pps->WorkPlan->file_path);
                    $pps->WorkPlan->delete();
                }

                // Guardar nuevo archivo
                $path = $file->storeAs('public/work_plan', $file->getClientOriginalName());
                WorkPlan::create([
                    'pps_id' => $pps->id,
                    'file_path' => $path,
                    'is_accepted' => 0
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud actualizada correctamente',
                'data' => $pps
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al actualizar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $pp = PPS::findOrFail($id);
            $pp->delete();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud eliminada correctamente',
                'data' => $id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function downloadWorkPlan($id)
    {
        try {
            $pps = PPS::find($id);

            $user = User::where('id', auth()->user()->id)->first();

            if ($pps->student_id != $user->id && auth()->user()->role_id != 1) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al descargar el plan de trabajo',
                    'message' => 'No está autorizado a realizar esta descarga'
                ], 400);
            } else if ($pps->teacher_id != $user->id && auth()->user()->role_id != 2) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al descargar el plan de trabajo',
                    'message' => 'No está autorizado a realizar esta descarga'
                ], 400);
            }

            $work_plan = WorkPlan::where('pps_id', $pps->id)->first();

            if (Storage::exists($work_plan->file_path)) {
                return response()->download(storage_path('app/' . $work_plan->file_path));
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el plan de trabajo',
                'message' => 'El archivo no existe'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el plan de trabajo',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function tomar($id)
    {
        try {
            $pps = PPS::findOrFail($id);
            $user = auth()->user();

            if ($user->role_id != 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado'
                ], 403);
            }

            $pps->responsible_id = $user->id;
            $pps->save();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud actualizada correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la solicitud',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function finalResume($id)
    {
        $pps = PPS::with('Responsible', 'Student', 'Teacher', 'WorkPlan', 'FinalReport')->findOrFail($id);

        return view('resume.resume', compact('pps'));
    }

    public function downloadStudentsReport()
    {
        try {
            // Incluir el autoloader de dompdf
            require_once public_path('dompdf/autoload.inc.php');  // Ajusta la ruta según donde hayas colocado 'dompdf'

            // Obtener las PPS del profesor autenticado
            $pps = Pps::where('teacher_id', auth()->user()->id)
                ->whereNotNull('responsible_id') // Validar que responsible_id no sea null
                ->get();
            $teacher = auth()->user(); // Obtener el profesor autenticado

            foreach ($pps as $pp) {
                // Aquí se cargan los seguimientos semanales asociados a cada PPS
                $pps->weeklyTrackings = $pp->weeklyTrackings; // Esto obtiene los seguimientos para cada PPS
            }

            // Usar DomPDF para generar el PDF
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('pps.report', compact('pps', 'teacher'))->render());

            // (Opcional) Configurar el tamaño del papel y orientación
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar el PDF (generarlo)
            $dompdf->render();

            // Descargar el PDF
            return response()->stream(
                function () use ($dompdf) {
                    echo $dompdf->output();
                },
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="informe_pps.pdf"'
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el informe final',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }



}
