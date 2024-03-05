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
        Schema::create('table_informe_final', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreing('id_pps')->references('id_pps')->on('pps');
            $table->blob('informe');
            $table->integer('aprobado');
            $table->string('observacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_informe_final');
    }
};
