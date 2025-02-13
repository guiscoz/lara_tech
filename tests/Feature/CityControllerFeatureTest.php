<?php

namespace Tests\Feature;

use App\Models\State;
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

    public function testGetCitiesReturnsCitiesForEachState()
    {
        // Obtém todos os estados cadastrados
        $states = State::all();

        // Percorre cada estado
        foreach ($states as $state) {
            // Faz uma requisição GET para a rota com o state_id
            $response = $this->getJson("/api/cities/{$state->id}");

            // Verifica o status da resposta
            $response->assertStatus(200);

            // Verifica a estrutura do JSON
            $response->assertJsonStructure([
                '*' => ['id', 'state_id', 'name'],
            ]);

            // Verifica se o state_id das cidades retornadas corresponde ao estado atual
            $response->assertJsonFragment(['state_id' => $state->id]);

            // Verifica se o número de cidades retornadas é maior que zero
            $this->assertGreaterThan(0, count($response->json()));
        }
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
