<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('student');
            $table->string('password');
            $table->string('phone_number', 15)->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignUlid('institution_id')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->dateTime('verification_token_generated_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('users');
    }
};
