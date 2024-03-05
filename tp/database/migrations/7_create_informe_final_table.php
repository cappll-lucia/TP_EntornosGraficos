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
        Schema::create('informe_final', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_pps')->constrained('pps')->onDelete('restrict')->onUpdate('cascade');
            $table->blob('informe');
            $table->boolean('aprobado')->default(false);
            $table->string('observacion')->nulleable();
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
