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
        Schema::create('plan_trabajo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_pps')->constrained('pps')->onDelete('restrict')->onUpdate('cascade');
            $table->blob('archivo_plan');
            $table->boolean('aprobado')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_trabajo');
    }
};
