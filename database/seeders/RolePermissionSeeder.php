<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Buscar as permissões criadas anteriormente
        $managePermissions = Permission::where('name', 'Gerenciar permissões')->first();
        $manageCampuses = Permission::where('name', 'Gerenciar campus')->first();
        $manageCourses = Permission::where('name', 'Gerenciar cursos')->first();
        $manageEvents = Permission::where('name', 'Gerenciar eventos')->first();
        $createExams = Permission::where('name', 'Criar provas')->first();
        $viewPerfomance = Permission::where('name', 'Ver desempenho')->first();

        // Associar permissões aos perfis
        $administratorRole = Role::where('name', 'Administrador')->first();
        $administratorRole->syncPermissions([$managePermissions, $manageCampuses, $manageCourses, $manageEvents]);

        $directorRole = Role::where('name', 'Diretor')->first();
        $directorRole->syncPermissions([$manageCampuses, $manageCourses, $manageEvents]);

        $coordinatorRole = Role::where('name', 'Coordenador')->first();
        $coordinatorRole->syncPermissions([$manageCourses, $manageEvents]);

        $professorRole = Role::where('name', 'Professor')->first();
        $professorRole->syncPermissions([$createExams]);

        $studentRole = Role::where('name', 'Aluno')->first();
        $studentRole->syncPermissions([$viewPerfomance]);
    }
}
