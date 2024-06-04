<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'Gerenciar permissões',
            'Gerenciar estabelecimentos',
            'Gerenciar cursos',
            'Gerenciar eventos',
            'Criar provas',
            'Dar notas',
            'Ver notas',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
