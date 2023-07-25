<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('institutions', function (Blueprint $table) {
            $table->ulid('id');
            $table->string('name');
            $table->string('alias');
            $table->string('email')->unique();
            $table->string('logo_url')->nullable();
            $table->string('po_box');
            $table->string('type');
            $table->string('address');
            $table->string('city');
            $table->foreignId('state_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('institutions');
    }
};
