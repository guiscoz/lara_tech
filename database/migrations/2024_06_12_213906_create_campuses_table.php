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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('address', 150);
            $table->string('address_number', 10);
            $table->string('district', 150);
            $table->string('zip_code', 8);
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('coordinator_id')->constrained('users');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
