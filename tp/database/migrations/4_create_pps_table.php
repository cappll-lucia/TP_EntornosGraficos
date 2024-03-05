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
            $table->boolean('terminada')->default(false);
            $table->string('observacion')->nulleable();
            $table->string('descripcion');
            $table->boolean('aprobada')->default(false);
            //id_alumno id_docente id_responsable
            $table->foreignId('id_alumno')->constrained('persona')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_docente')->constrained('persona')->onDelete('restrict')->onUpdate('cascade')->nulleable();
            $table->foreignId('id_responsable')->constrained('persona')->onDelete('restrict')->onUpdate('cascade')->nulleable();
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
