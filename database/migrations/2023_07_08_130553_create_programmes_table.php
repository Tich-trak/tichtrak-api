<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('programmes', function (Blueprint $table) {
            $table->ulid('id');
            $table->foreignId('institution_id');
            $table->foreignId('faculty_id');
            $table->foreignId('department_id');
            $table->string('name');
            $table->string('goal')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('programmes');
    }
};