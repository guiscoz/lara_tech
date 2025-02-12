# Projeto

Esta é uma plataforma desenvolvida para facilitar a administração e organização de uma escola técnica de tecnologia LaraTech. A aplicação oferece funcionalidades robustas para gerenciar campus, eventos e cursos, proporcionando uma experiência integrada para alunos, professores, coordenadores e administradores.

## Funcionalidades

- Gestão de Campus: Cadastro e gerenciamento de informações detalhadas de cada campus, incluindo sua localização.

- Calendário de Eventos: Visualização e administração de eventos acadêmicos, permitindo o registro de datas, horários e detalhes específicos de cada evento.

- Administração de Cursos: Controle completo sobre os cursos oferecidos, com capacidade de associar professores, definir a quantidade de semestres e monitorar a participação dos alunos.

- Matrícula de Alunos: Facilidade para alunos se matricularem em cursos disponíveis, com atribuição automática do perfil de aluno e integração com a gestão acadêmica.

## Tecnologias usadas

- Laravel versão 11: Framework PHP para o desenvolvimento web e foi utilizada a versão 8.3.8 do PHP.
- MySQL versão 8.4: Sistema de gerenciamento de banco de dados relacional.
- HTML/CSS/Bootstrap: Tecnologias front-end para a interface do usuário.
- JQuery: Para o cadastro de campus, foi criada funções no jquery para prencher os campos de endereço ao digitar um cep válido.

# Ao clonar o repositório

Agora será dados as instruções do que deve ser feito para esta plataforma rodar na sua máquina após clonar o repositório

## Instalações

Será necessário ter instalar o php, MySQL, composer e o apache ou ngnix. Você também pode instalar o Laragon que vai instalar o apache e o nginx para você e executará eles quando o Laragon for ativado.

## Variáveis de ambiente

Agora deve criar o arquivo '.env' usando o '.env.example' como base para armazenar as variáveis de ambientes. Ambos os arquivos ficarão na mesma pasta. Pode todo o conteúdo do exemplo para o arquivo final, só será necessário alterar essas linhas:


```
DB_DATABASE=laratech
DB_USERNAME=SEU_DB_USERNAME
DB_PASSWORD=SUA_SENHA_MYSQL

ADMIN_EMAIL=EMAIL_DO_ADMINISTRADOR
ADMIN_PASSWORD=SENHA_DO_ADMINISTRADOR
```


- No DB_DATABASE vai ser inserido o nome do banco de dados do MySQL que será utilizado.
- DB_USERNAME é o seu nome de usuário do MySQL que por padrão é root, mas o seu caso pode ser diferente.
- DB_PASSWORD vai receber sua senha do MySQL. Caso não tiver uma, pode deixar vazio.


- ADMIN_EMAIL contém o email do Super Admin que terá todas as permissões e todos os perfis do sistema.
- ADMIN_PASSWORD vai receber sua senha.
- Os demais campos do '.env' você altera se quiser.


## Seeders

Os arquivos de seeders são responsáveis por gerar dados necessários para a execução do sistema. Eles vão gerar os dados de perfis, permissões e ainda vai criar o usuário super admin que receberá todas as permissões. Além disso tem os dados de cidades e estados brasileiros que serão importantes para o formulário de criação de campus. 
Por fim, ele vai gerar alguns usuários com determinados perfis para testar as funcionalidades do sistema. Será gerado um administrador, um diretor, dois coordenadores, três professores e mais cinco usuários sem perfil. Todos eles terão 'password' como sua senha.

## Comandos do terminal

Primeiramente é preciso instalar o pacote do composer e do npm, já que seus arquivos não vem junto com o repositório e podem estar sempre precisando de atualizações. Para instalar os pacotes, basta executar estes comandos:

```
composer install
npm install
```


Agora preciso gerar as tabelas de dados em seu banco. Aqui também será gerado o usuário Super Admin, para isso use o comando:
```
php artisan migrate
```


Depois disso será necessários gerar os dados dentro do arquivo de seeders, dentro dele está uma lista de perfis e permissões que será necessário para a plataforma. Além disso, será gerados vários usuários no banco de dados tendo alguns perfis definidos para testar suas funcionalidades. Antes disso, será gerado um usuário com o perfil 'Super Admin' que terá todas as permissões. Seu email e senha será definido no arquivo 'README.md' enquanto a senha dos demais usuários gerados pelos seeders será 'password'. Para gerar esses dados, basta user o comando:
```
php artisan db:seed
```


Talvez seja necessário uma chave de aplicação (Application Key). Para resolver o problema basta utilizar este comando no terminal:
```
php artisan key:generate
```

## Testes

Para verificar se o projeto está funcionado sem precisar testar tudo na mão, foram criado vários arquivos de testes para evitar todo esse trabalho. Mas antes será necessário criar o arquivo '.env.testing' com a seguinte estrututa:

```
APP_ENV=testing
APP_DEBUG=true
APP_KEY=SUA_APP_KEY

DB_CONNECTION=mysql
DB_HOST=127.0.0.1_ou_seu_host
DB_PORT=3306
DB_DATABASE=laratech_tests
DB_USERNAME=SEU_DB_USERNAME
DB_PASSWORD=SUA_SENHA_MYSQL

ADMIN_EMAIL=EMAIL_DO_ADMINISTRADOR
ADMIN_PASSWORD=SENHA_DO_ADMINISTRADOR
```

Também será necessário rodar migrations no banco de testes com o comando:
```
php artisan migrate --env=testing
```

O nome do banco de teste está definido no arquivo 'phpunitxml' na linha que está escrito "<env name="DB_DATABASE" value="laratech_tests"/>". Se quiser usar outro nome para o banco de dados, também será necessário mexer nessa linha.

## Docker


Caso queira executar sem precisar instalar o php, composer ou mysql, é possível fazer isso com o Docker. Seu ambiente foi definido pelo arquivo 'docker-compose.yml' gerado pelo recurso Sail do próprio Laravel. O primeiro comando de execução necessário é de construção de ambiente que irá gerar dois containers: um para o laravel e outro do mysql 
```
docker-compose build
```


Depois disso será necessário subir o ambiente com o comando:
```
docker-compose up -d
```

Caso queira consultar dados dos containers gerados, você usar este comando:
```
docker ps
```


Em seguida você deve rodar as migrations e o seeder:
```
docker-compose exec laratech php artisan migrate --seed
```

Graças ao uso do Sail deste framework, não há necessidade de um comando para a execução do projeto porque suas páginas já estarão disponíveis no localhost (http://localhost:8000/) assim que os containers forem ativados. Apenas será necessário definir essas variaveis de ambiente no arquivo '.env':

```
WWWGROUP=1000_ou_id_grupo_host
WWWUSER=1000_ou_id_usuario_local
```