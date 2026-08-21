<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The old core migration may already have created this table.
        // Recreate it here so its id type is guaranteed to match foreignId().
        if (Schema::hasTable('tingkat_prestasi')) {
            Schema::drop('tingkat_prestasi');
        }

        Schema::create('tingkat_prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tingkat_prestasi');
    }
};
