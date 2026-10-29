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
        Schema::create('penilaian_pjbls', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            $table->foreignId('project_mentor_id')
                  ->nullable()
                  ->constrained('project_mentors')
                  ->onDelete('set null');

            $table->enum('status', ['kompeten', 'belum_kompeten'])->default('kompeten');
            $table->decimal('nilai', 5, 2);
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_pjbls');
    }
};
