
# Change Log
Todas as alterações feitas no projeto a partir do dia 24/06/2024 será documentada neste arquivo. As mudanças feitas anteriormente não estão documentadas porque este arquivo não foi criado antes.
 
## 24/06/2024
 
Neste dia foi criado uma branch de cadastro de cursos. O plano é permitir o usuário se cadastrar em um curso disponibilizado pela plataforma e também será criado uma página de cursos no qual o aluno se cadastrou.
 
### Adicionado
- Arquivo 'changelog.md' para registrar todas as alterações feitas no projeto.
- Tabela pivot para atrelar o usuário a um curso que ele se cadastrou. Depois foi criar o arquivo 'CourseEnrollmentController.php' para fazer ligação do curso ao usuário, dando a ele o perfil de aluno. No arquivo de model do usuário, foi adicionada o relaciomento 'belongsToMany'. Os códigos adicionados podem sofrer alterações no dia seguinte.
 
### Alterado
- Nos arquivos 'PermissionsTableSeeder.php', 'RolePermissionSeeder.php', 'CampusController.php', o termo 'estabelecimentos' foi trocado por 'campus'. Esta mudança foi feita porque faria mais sentir ter uma permissão de gerenciar campus do que estabelecimentos, já que há a opção de cadastrar campus.
- A permissão 'Dar notas' foi removida do 'PermissionTableSeeder.php' por não haver mais necessidade de continuar existindo. O plano é usar a permissão 'Criar provas' para a mesma função.
- A permissão 'Ver notas' foi renomeada para 'Ver desempenho'.
- No arquivo 'DatabaseSeeder' não será mais gerado usuários com o perfil 'Aluno'. Em vez disso, eles não terão nenhum perfil.

## 25/06/2024
 
Neste dia foi testado os código para cadastrar um usuário a um curso.