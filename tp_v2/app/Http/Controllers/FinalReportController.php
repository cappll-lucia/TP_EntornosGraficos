<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PPS;
use App\Models\FinalReport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FinalReportController extends Controller
{
    public function details($id){
        $pps = PPS::findOrFail($id);

        $fr = FinalReport::where('pps_id', $id)->first();

        $existsFR = FinalReport::where('pps_id', $id)->exists();

        return view('final_report.details', compact('pps', 'fr', 'existsFR'));
    }

    public function createFR($id)
    {
        try {
            if (auth()->user()->role_id != 3) {
                return redirect()
                    ->back()
                    ->with('error', 'No tienes permisos para realizar esta acción.');
            }

            $pps = PPS::findOrFail($id);
    
            $fr = FinalReport::create([
                'pps_id' => $pps->id,
                'file_path' => null,
                'is_accepted' => false,
                'observations' => '',
            ]);
    
            return redirect()
            ->route('fr.details', ['id' => $pps->id])
            ->with('success', 'El reporte final se ha creado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al crear el Final Report: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        try {
            $pps = PPS::findOrFail($id);
            $fr = FinalReport::where('pps_id', $pps->id)->first();

            if (Storage::exists($fr->file_path)) {
                return response()->download(storage_path('app/' . $fr->file_path));
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el plan de trabajo',
                'message' => 'El archivo no existe'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el reporte',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    // public function uploadFR(Request $request)
    // {
    //     try {
    //         $pps = PPS::find($request->input('pps_id'));
    //         $student = User::where('user_id', auth()->user()->id)->first();

    //         if ($pps->student_id != $student->id || auth()->user()->role_id != 1) {
    //             return response()->json([
    //                 'success' => false,
    //                 'title' => 'Error al subir el reporte',
    //                 'message' => 'No está autorizado a realizar esta acción'
    //             ], 400);
    //         }

    //         DB::beginTransaction();
    //         $file = $request->file('file');
    //         if ($file->isValid()) {
    //             $path = $file->store('public/final_reports');                
    //             FinalReport::create([
    //                 'pps_id' => $pps->id,
    //                 'file_path' => $path,
    //                 'is_accepted' => false,
    //                 'observations' => ''
    //             ]);

    //             Mail::to($pps->Teacher->email)->send(
    //                 new UploadFinalReportEmail(
    //                     $pps->Student->last_name . ', ' . $pps->Student->first_name,
    //                     $pps->Student->email,
    //                     $pps->id,
    //                     $pps->Teacher->first_name
    //                 )
    //             );

    //             DB::commit();
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Reporte subido correctamente',
    //                 'data' => $pps
    //             ], 201);
    //         }
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'title' => 'Error al subir el reporte',
    //             'message' => 'El archivo no es válido'
    //         ], 400);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'title' => 'Error al subir el reporte',
    //             'message' => 'Intente nuevamente o comuníquese para soporte',
    //             'error' => $e->getMessage()
    //         ], 400);
    //     }
    // }
}
