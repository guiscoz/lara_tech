<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesUsersTableSeeder::class,
            RolePermissionSeeder::class,
        ]);

        $roles = [
            'Administrador',
            'Diretor',
            'Coordenador',
            'Coordenador',
            'Professor',
            'Professor',
            'Professor',
            'Aluno', 
            'Aluno',
            'Aluno',
            'Aluno',
            'Aluno',
        ];

        // Criar os próximos usuários e atribuir perfis
        foreach ($roles as $role) {
            $user = User::factory()->create();
            $user->assignRole($role);
        }
    }
}
