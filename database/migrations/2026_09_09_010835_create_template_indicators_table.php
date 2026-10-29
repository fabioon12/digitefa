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
        Schema::create('template_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_template_id')
                ->constrained('certificate_templates')
                ->onDelete('cascade'); // Menghubungkan indikator ke template
            $table->string('indikator'); // Contoh: "Memahami Pemrograman Berorientasi Objek"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_indicators');
    }
};
