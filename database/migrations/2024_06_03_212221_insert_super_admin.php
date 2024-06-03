<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $email = env('ADMIN_EMAIL');
        $password = bcrypt(env('ADMIN_PASSWORD'));

        DB::insert(
            'insert into users(name, email, password) values (?, ?, ?)',
            ['Administrador', $email, $password]
        );
    }

    public function down()
    {
        $email = env('ADMIN_EMAIL');
        User::where('email', '=', $email)->delete();
    }
};
