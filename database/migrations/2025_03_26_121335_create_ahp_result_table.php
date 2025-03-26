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
        Schema::create('ahp_result', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->decimal('final_score', 8, 4);
            $table->integer('rank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_result');
    }
};
