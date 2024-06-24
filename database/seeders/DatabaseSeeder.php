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
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
        ]);

        $roles = [
            'Administrador',
            'Diretor',
            'Coordenador',
            'Coordenador',
            'Professor',
            'Professor',
            'Professor',
        ];

        // Criar os próximos usuários e atribuir perfis
        foreach ($roles as $role) {
            $user = User::factory()->create();
            $user->assignRole($role);
        }

        // Usuários sem perfis
        $user = User::factory(5)->create();
    }
}
