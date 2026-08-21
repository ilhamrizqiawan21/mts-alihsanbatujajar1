<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 9);
            $table->enum('semester', ['1', '2']);
            $table->boolean('is_aktif')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->index(['tahun', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran');
    }
};
