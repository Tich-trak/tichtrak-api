<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('institution_id')->constrained();;
            $table->string('title');
            $table->string('summary');
            $table->string('body');
            $table->string('image_url')->nullable();
            $table->string('external_url')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
