<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $newRoles = [
            [
                'name' => 'Super Admin'
            ],
            [
                'name' => 'Diretor'
            ],
            [
                'name' => 'Coordenador'
            ],
            [
                'name' => 'Professor'
            ],
            [
                'name' => 'Aluno'
            ]
        ];

        foreach ($newRoles as $roles) {
            Role::create($roles);
        }
    }
}
