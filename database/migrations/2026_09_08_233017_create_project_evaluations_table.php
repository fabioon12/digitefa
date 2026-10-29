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
        Schema::create('project_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade'); // Guru/Mentor yang memberi nilai
            $table->enum('status_kompetensi', ['kompeten', 'belum_kompeten'])->default('belum_kompeten');
            $table->unsignedTinyInteger('nilai_akhir')->default(0); // 0-100
            $table->text('catatan_guru')->nullable();
            $table->timestamps();
            $table->unique(['project_id', 'student_id','evaluator_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_evaluations');
    }
};
