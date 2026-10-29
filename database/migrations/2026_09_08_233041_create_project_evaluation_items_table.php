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
        Schema::create('project_evaluation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_evaluation_id')->constrained('project_evaluations')->onDelete('cascade');
            $table->text('indikator'); 
            $table->boolean('is_achieved')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_evaluation_items');
    }
};
