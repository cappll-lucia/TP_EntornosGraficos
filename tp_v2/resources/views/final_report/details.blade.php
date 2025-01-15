@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-body">
                        <h2 class="box-title">Reporte final</h2>
                        @if (auth()->user()->role_id == '3' && !$existsFR)
                            <div class="mb-3">
                                <form id="generate-wt-form" action="{{ route('fr.generate', $fr->id) }}" method="POST">
                                    @csrf
                                    <button id="btnGeneratewts" class="btn btn-primary">
                                        Generar reporte final
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if (!$existsFR)
                            <div class="alert alert-warning" role="alert">
                                El reporte final aún no han sido generado. Por favor, espera a que el responsable lo cree.
                            </div>
                        @else
                            <p class="box-subtitle">{{ $fr->created_at->format('d/m/Y') }}</p>
                            <hr class="m-t-0 m-b-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Reporte final del estudiante:</b></td>
                                        <td>
                                            @if ($fr->file_path != null)
                                                <a href="{{ Storage::url($fr->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                                    Ver archivo
                                                </a>
                                            @else
                                                <span class="text-danger">No se ha subido el archivo</span>
                                                @if (auth()->user()->role_id == '1')
                                                    <br>
                                                    <form id="uploadForm" action="{{ route('fr.saveFile', ['id' => $fr->id]) }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="fileInput" class="form-label">Selecciona un archivo</label>
                                                            <input type="file" class="form-control" id="fileInput" name="file" accept=".pdf,.doc,.docx" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">
                                                            Confirmar PDF
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4">
                                            <b class="font-weight-bold">Observaciones:</b>
                                            @if (auth()->user()->role_id == '2' && $fr->is_accepted === 0)
                                                <button class="btn btn-sm waves-effect waves-light" type="button"
                                                        data-bs-toggle="modal" data-bs-target="#modalObservation">
                                                    <i class="bi bi-pencil-square"></i> Escribir observación
                                                </button>
                                            @endif
                                        </td>
                                        <td>{{ $fr->observation != null ? $fr->observation : "-" }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Estado:</b></td>
                                        <td>{{ $fr->is_accepted ? 'Aprobado' : 'Pendiente de aprobación' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <hr class="m-t-0 m-b-20"> --}}
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (auth()->user()->role_id == '2' && $fr->is_accepted === 0)
                                <div class="d-flex justify-content-end">
                                    <form id="form-approve" action="{{ route('fr.approve', ['id' => $fr->id]) }}" method="post">
                                        @csrf
                                        <button id="btnFinish" class="btn btn-success waves-effect waves-light"
                                            type="button">Aprobar solicitud</button>
                                    </form>
                                    {{-- Boton de rechazo: envia un mail para que cambie la desc o fechas? se tendria que justamente comentar en observaciones asi se envia eso x mail --}}
                                    <button class="btn btn-sm btn-danger">Rechazar</button>
                                    <hr class="m-t-0 m-b-20">
                                </div>
                            @endif
                            </div>
                            {{-- <div>
                                <button id="btnSeguimiento" class="btn btn-secondary" disabled>Ir a seguimientos semanales</button>
                            </div> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection