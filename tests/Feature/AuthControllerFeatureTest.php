<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerFeatureTest extends TestCase
{
    use RefreshDatabase; // Recria o banco de dados para cada teste

    // Teste para o formulário de registro
    public function testRegisterFormReturnsView()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    // Teste para o registro de usuário com dados válidos
    public function testRegisterWithValidData()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post('/register', $data);

        $response->assertRedirect('/'); // Verifica o redirecionamento após o registro
        $this->assertAuthenticated(); // Verifica se o usuário está autenticado
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']); // Verifica se o usuário foi criado no banco de dados
    }

    // Teste para o registro de usuário com dados inválidos
    public function testRegisterWithInvalidData()
    {
        $data = [
            'name' => '', // Nome vazio (inválido)
            'email' => 'invalid-email', // E-mail inválido
            'password' => 'short', // Senha curta
            'password_confirmation' => 'short',
        ];

        $response = $this->post('/register', $data);

        $response->assertSessionHasErrors(['name', 'email', 'password']); // Verifica se há erros de validação
        $this->assertGuest(); // Verifica se o usuário não está autenticado
    }

    // Teste para o formulário de login
    public function testLoginFormReturnsView()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // Teste para o login com credenciais válidas
    public function testLoginWithValidCredentials()
    {
        // Cria um usuário para teste
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password123'),
        ]);

        $credentials = [
            'email' => 'john@example.com',
            'password' => 'Password123',
        ];

        $response = $this->post('/login', $credentials);

        $response->assertRedirect('/'); // Verifica o redirecionamento após o login
        $this->assertAuthenticatedAs($user); // Verifica se o usuário está autenticado
    }

    // Teste para o login com credenciais inválidas
    public function testLoginWithInvalidCredentials()
    {
        $credentials = [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->post('/login', $credentials);

        $response->assertSessionHasErrors(['email']); // Verifica se há erro de credenciais inválidas
        $this->assertGuest(); // Verifica se o usuário não está autenticado
    }

    // Teste para o logout
    public function testLogout()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/'); // Verifica o redirecionamento após o logout
        $this->assertGuest(); // Verifica se o usuário não está mais autenticado
    }
}
