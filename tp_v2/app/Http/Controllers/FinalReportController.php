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
}
