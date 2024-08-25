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
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function download($id)
    {
        try {
            $pps = PPS::findOrFail($id)->load('FinalReport');
            $fr = $pps->FinalReport;
            if (Storage::exists($fr->file_path)) {
                return response()->download(storage_path('app/' . $fr->file_path));
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el reporte',
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

    public function upload(Request $request)
    {
        try {
            $pps = PPS::find($request->input('pps_id'));
            $student = User::where('user_id', auth()->user()->id)->first();
            if ($pps->student_id != $student->id || auth()->user()->role_id != 2) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al subir el reporte',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }

            DB::beginTransaction();
            $file = $request->file('file');
            if ($file->isValid()) {
                $path = $file->store('public/final_reports');                
                FinalReport::create([
                    'pps_id' => $pps->id,
                    'file_path' => $path,
                    'is_accepted' => false,
                    'observations' => ''
                ]);

                /*Mail::to($pps->Teacher->User->email)->send(
                    new UploadFinalReportEmail(
                        $pps->Student->lastname . ', ' . $pps->Student->first_name,
                        $pps->Student->User->email,
                        $pps->id,
                        $pps->Teacher->name
                    )
                );*/
                
                $pps->is_finished = true;
                $pps->save();

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Reporte subido correctamente',
                    'data' => $pps
                ], 201);
            }
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al subir el reporte',
                'message' => 'El archivo no es válido'
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al subir el reporte',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
