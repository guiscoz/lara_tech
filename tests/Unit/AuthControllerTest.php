<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterFormReturnsView()
    {
        $controller = new AuthController();
        $response = $controller->registerForm();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('auth.register', $response->name());
    }

    public function testLoginFormReturnsView()
    {
        $controller = new AuthController();
        $response = $controller->loginForm();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('auth.login', $response->name());
    }

    public function testLogoutRedirectsToHomePage()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('logout')->once();

        // Cria uma instância do AuthController
        $controller = new AuthController();

        // Simula o logout
        $response = $controller->logout(new Request());

        // Verifica se o redirecionamento está correto
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/', $response->getTargetUrl());
    }
}
