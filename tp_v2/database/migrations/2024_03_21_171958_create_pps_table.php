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
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('responsible_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->string('description');
            $table->string('observation')->nullable();
            $table->softDeletes();
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
