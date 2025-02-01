<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PPS\PPSUpdateRequest;
use App\Models\PPS;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\WeeklyTracking;
use App\Models\FinalReport;

class WeeklyTrackingController extends Controller
{
    public function index($id)
    {

        $pps = PPS::with('WeeklyTrackings')->findOrFail($id);

        $wts = $pps->WeeklyTrackings()->exists();

        $lastWt = $pps->WeeklyTrackings->last();
        $isLastWtApproved = $pps->WeeklyTrackings->isNotEmpty()
            ? $pps->WeeklyTrackings->every(fn($wt) => $wt->is_accepted)
            : false;
        $existsFR = FinalReport::where('pps_id', $id)->exists();

        return view('weekly_trackings.index', compact('pps', 'wts', 'isLastWtApproved', 'existsFR'));
    }

    public function generateWT(Request $request, $id)
    {
        try {
            $pps = PPS::findOrFail($id);


            for ($i = 1; $i <= 10; $i++) {
                WeeklyTracking::create([
                    'pps_id' => $pps->id,
                    'file_path' => null,
                    'is_accepted' => 0,
                ]);
            }

            return redirect()->route('getWeeklyTrackings', ['id' => $pps->id]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al generar los seguimientos: ' . $e->getMessage());
        }
    }

    public function details($id)
    {
        $wt = WeeklyTracking::find($id);
        $pps = PPS::find($wt->pps_id);

        if (!$wt) {
            return redirect()->route('pps.index')->with('error', 'El seguimiento semanal no existe.');
        }

        return view('weekly_trackings.details', compact('wt', 'pps'));
    }

    /*public function delete(string $id)
    {
        try {
            $wt = WeeklyTracking::findOrFail($request->input('id'))->load('PPS');
            $rol = auth()->user()->role_id;
            if (($rol != 1 && $rol != 2) || ($rol != 1 && $wt->PPS->student_id != auth()->user()->id)) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al eliminar la solicitud',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }
            if (Storage::exists($wt->file_path)) {
                Storage::delete($wt->file_path);
            }
            $wt->delete();
            return response()->json([
                'success' => true,
                'message' => 'Seguimiento eliminado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar la seguimiento',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }*/

    public function download($id)
    {
        try {
            $wt = WeeklyTracking::find($id)->load('PPS');
            $user = User::where('id', auth()->user()->id)->first();
            if ($wt->PPS->student_id != $user->id && auth()->user()->role_id == 1) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al descargar el seguimiento semanal',
                    'message' => 'No está autorizado a realizar esta descarga'
                ], 400);
            } else if ($wt->PPS->teacher_id != $user->id && auth()->user()->role_id == 2) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al descargar el seguimiento semanal',
                    'message' => 'No está autorizado a realizar esta descarga'
                ], 400);
            }

            if (Storage::exists($wt->file_path)) {
                return response()->download(storage_path('app/' . $wt->file_path));
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el seguimiento semanal',
                'message' => 'El archivo no existe'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el seguimiento semanal',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

}