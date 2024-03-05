<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('terminada');
            $table->string('observacion');
            $table->string('descripcion');
            $table->integer('aprobada');
            //id_alumno id_docente id_responsable
            $table->foreing('id_alumno')->references('id_persona')->on('persona');
            $table->foreing('id_docente')->references('id_persona')->on('persona');
            $table->foreing('id_responsable')->references('id_persona')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pps');
    }
};
