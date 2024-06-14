<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->date('event_date')->after('creator_id');
            $table->time('event_time')->after('event_date');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('date');
            $table->dropColumn(['event_date', 'event_time']);
        });
    }
};
