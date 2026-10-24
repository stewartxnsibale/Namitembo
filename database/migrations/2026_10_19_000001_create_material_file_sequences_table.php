<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_file_sequences', function (Blueprint $table) {
            $table->string('department', 3)->primary();
            $table->unsignedInteger('next_number')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_file_sequences');
    }
};
