<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class RolesUsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::find(1)->roles()->attach(1);
    }
}
