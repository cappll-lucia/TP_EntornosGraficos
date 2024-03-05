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
        Schema::create('seguimiento_semanal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pps')->constrained('pps')->onDelete('restrict')->onUpdate('cascade');
            $table->blob('archivo_seguimiento');
            $table->boolean('aprobado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_semanal');
    }
};
