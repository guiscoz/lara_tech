
# Change Log
Todas as alterações feitas no projeto a partir do dia 24/06/2024 será documentada neste arquivo. As mudanças feitas anteriormente não estão documentadas porque este arquivo não foi criado antes.
 
## 24/06/2024
 
Neste dia foi criado uma branch de cadastro de cursos. O plano é permitir o usuário se matricular em um curso disponibilizado pela plataforma e também será criado uma página de cursos no qual o aluno se matriculou.
 
### Adicionado
- Arquivo 'changelog.md' para registrar todas as alterações feitas no projeto.
- Tabela pivot para atrelar o usuário a um curso que ele se matriculou. Depois foi criar o arquivo 'CourseEnrollmentController.php' para fazer ligação do curso ao usuário, dando a ele o perfil de aluno. No arquivo de model do usuário, foi adicionada o relaciomento 'belongsToMany'. Os códigos adicionados podem sofrer alterações no dia seguinte.
 
### Alterado
- Nos arquivos 'PermissionsTableSeeder.php', 'RolePermissionSeeder.php', 'CampusController.php', o termo 'estabelecimentos' foi trocado por 'campus'. Esta mudança foi feita porque faria mais sentir ter uma permissão de gerenciar campus do que estabelecimentos, já que há a opção de cadastrar campus.
- A permissão 'Dar notas' foi removida do 'PermissionTableSeeder.php' por não haver mais necessidade de continuar existindo. O plano é usar a permissão 'Criar provas' para a mesma função.
- A permissão 'Ver notas' foi renomeada para 'Ver desempenho'.
- No arquivo 'DatabaseSeeder' não será mais gerado usuários com o perfil 'Aluno'. Em vez disso, eles não terão nenhum perfil.

## 25/06/2024
 
Neste dia foi testado os código para cadastrar um usuário a um curso.

### Alterado
- Foi removido as colunas 'id' da views de index
- O arquivo index das view de cursos foi alterada para adicionar a opção de se matricular ao curso e um filtro para cursos matriculados e não matriculados

### Removido
- A função 'enroll' foi movida do arquivo 'CourseEnrollmentController.php' para o 'CourseController.php' para que todas as função atreladas aos cursos ficassem em um único controller. Dessa forma, o arquivo 'CourseEnrollmentController.php' foi apagado.

### Adicionado
- Arquivo de view 'show' para os cursos, mostrando suas informações e alunos matriculados.
- Relacionamento de estudantes no modelo Course.

### Alterado
- A função show de CourseController foi alterado para mostrar os dados de alunos matriculados também.
- O arquivo 'welcome.blade.php' foi alterado para disponibilizar uma descrição da escola LaraTech.
- Agora o arquivo 'README.md' está descrevendo o projeto.
- Todas as alterações foram commitadas na branch 'cadastro-curso' que por sua vez fez um merge com a branch 'main'.

### O que falta fazer
- Criar um funções de criação de provas e de dar notas que somente quem tem o perfil de Professor pode acessar. Depois será criada páginas onde o aluno pode ver suas notas.
- Criar funções de testes para todos os controllers criados até então. Começando pelos testes unitários.

## 09/08/2024
- Foi adicionado um comentário nos arquivos CitiesTableSeeder e StatesTableSeeder para dar crédito ao repositório original deste material criado para os estados e municípios brasileiros. Estes seeders orignalmente criados neste repositório: // Créditos do seeder: https://github.com/magnobiet/laravel-states-cities-brazil