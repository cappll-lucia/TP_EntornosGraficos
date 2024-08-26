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

class WeeklyTrackingController extends Controller
{
    public function delete(string $id)
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
    }

    public function accept(Request $request)
    {
        try {
            $wt = WeeklyTracking::findOrFail($request->input('id'))->load('PPS');
            $pps = $wt->PPS;
            $rol = auth()->user()->role_id;
            if ($rol != 2 || $wt->PPS->teacher_id != auth()->user()->User->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aceptar el seguimiento',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }
            $wt->is_accepted = true;
            $wt->save();

            /*Mail::to($pps->Student->User->email)->send(
                new ApproveWeeklyTrackingEmail(
                    $pps->Student->name,
                    $pps->id,
                    $pps->Teacher->User->email
                )
            );*/

            return response()->json([
                'success' => true,
                'message' => 'Seguimiento aceptado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al aceptar el seguimiento',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

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