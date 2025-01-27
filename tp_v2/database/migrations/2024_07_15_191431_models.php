<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('final_report', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pps_id')->constraint('pps');
            $table->string("file_path");
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_editable')->default(false);
            $table->string('observation')->nullable();
            $table->boolean('is_checked')->default(false);
            $table->softDeletes();
        });

        Schema::create('work_plan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pps_id')->constraint('pps');
            $table->string("file_path")->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->softDeletes();
        });

        Schema::create('weekly_tracking', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pps_id')->constraint('pps');
            $table->string("file_path")->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_editable')->default(false);
            $table->string('observation')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_tracking');
        Schema::dropIfExists('final_report');
        Schema::dropIfExists('work_plan');
    }
};
