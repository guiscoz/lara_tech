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
        $manageEstablishments = Permission::where('name', 'Gerenciar estabelecimentos')->first();
        $manageCourses = Permission::where('name', 'Gerenciar cursos')->first();
        $manageEvents = Permission::where('name', 'Gerenciar eventos')->first();
        $createExams = Permission::where('name', 'Criar provas')->first();
        $giveGrades = Permission::where('name', 'Dar notas')->first();
        $viewGrades = Permission::where('name', 'Ver notas')->first();

        // Associar permissões aos perfis
        $administratorRole = Role::where('name', 'Administrador')->first();
        $administratorRole->syncPermissions([$managePermissions, $manageEstablishments, $manageCourses, $manageEvents]);

        $directorRole = Role::where('name', 'Diretor')->first();
        $directorRole->syncPermissions([$manageEstablishments, $manageCourses, $manageEvents]);

        $coordinatorRole = Role::where('name', 'Coordenador')->first();
        $coordinatorRole->syncPermissions([$manageCourses, $manageEvents]);

        $professorRole = Role::where('name', 'Professor')->first();
        $professorRole->syncPermissions([$createExams, $giveGrades]);

        $studentRole = Role::where('name', 'Aluno')->first();
        $studentRole->syncPermissions([$viewGrades]);
    }
}
