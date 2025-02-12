<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerFeatureTest extends TestCase
{
    public function testHomeRouteReturnsWelcomeView()
    {
        // Faz uma requisição GET para a rota home
        $response = $this->get('/');

        // Verifica se o status da resposta é 200 (OK)
        $response->assertStatus(200);

        // Verifica se a view retornada é a view 'welcome'
        $response->assertViewIs('welcome');
    }
}
