<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityControllerFeatureTest extends TestCase
{
    use RefreshDatabase; // Recria o banco de dados para cada teste

    protected function setUp(): void
    {
        parent::setUp();

        // Executa os Seeders na ordem correta
        Artisan::call('db:seed', ['--class' => 'StatesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'CitiesTableSeeder']);
    }

    public function testGetCitiesReturnsCitiesForState()
    {
        // Define o state_id para o teste (assumindo que o StateSeeder cria estados com IDs 1, 2, etc.)
        $stateId = 11;

        // Faz uma requisição GET para a rota com o state_id
        $response = $this->getJson("/api/cities/{$stateId}");

        // Verifica o status da resposta
        $response->assertStatus(200);

        // Verifica se o JSON retornado contém cidades
        $response->assertJsonCount(52); // Ajuste o número conforme o CitySeeder

        // Verifica a estrutura do JSON
        $response->assertJsonStructure([
            '*' => ['id', 'state_id', 'name'],
        ]);
    }

    public function testGetCitiesReturnsEmptyArrayForInvalidState()
    {
        // Faz uma requisição GET para um state_id que não existe
        $response = $this->getJson('/api/cities/999');

        // Verifica o status da resposta
        $response->assertStatus(200);

        // Verifica se o JSON retornado está vazio
        $response->assertJsonCount(0);
    }
}
