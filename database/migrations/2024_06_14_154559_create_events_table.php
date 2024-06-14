<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campuses')->onDelete('cascade');
            $table->dateTime('date');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
