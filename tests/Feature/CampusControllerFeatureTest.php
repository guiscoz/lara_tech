<?php

namespace Tests\Feature;

use App\Models\Campus;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampusControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $campus;
    protected $data;
    protected $nonExistingId;
    protected $userNoPermission;
    protected $userWithPermission;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'RolesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'PermissionsTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'RolesUsersTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'RolePermissionSeeder']);
        Artisan::call('db:seed', ['--class' => 'StatesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'CitiesTableSeeder']);

        $this->campus = Campus::create([
            'name' => 'Campus Teste',
            'address' => 'Rua Exemplo',
            'address_number' => '123',
            'district' => 'Centro',
            'zip_code' => '12345678',
            'city_id' => 1100015,
            'state_id' => 11,
            'coordinator_id' => User::first()->id,
        ]);

        $this->data = [
            'name' => 'Campus Teste 2',
            'address' => 'Rua Exemplo 2',
            'address_number' => '321',
            'district' => 'Centro',
            'zip_code' => '87654321',
            'city_id' => 1100023,
            'state_id' => 11,
            'coordinator_id' => User::factory()->create()->id,
        ];

        $this->userNoPermission = User::factory()->create();
        $this->userWithPermission = User::factory()->create()->givePermissionTo('Gerenciar campus');
        $this->nonExistingId = 999999;
    }

    public function testCampusIndexView()
    {
        $response = $this->get(route('campus.index'));
        $response->assertStatus(200);
    }

    public function testShowViewReturnsCampusData()
    {
        $response = $this->get(route('campus.show', $this->campus->id));
        $response->assertStatus(200);
    }

    public function testShowViewReturns404ForNonExistingCampus()
    {
        $response = $this->get(route('campus.show', $this->nonExistingId));
        $response->assertStatus(404);
    }

    public function testCreateViewRedirectUnauthenticatedUser()
    {
        $response = $this->get(route('campus.create'));
        $response->assertRedirect(route('login'));
    }

    public function testCreateViewRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->get(route('campus.create'));
        $response->assertStatus(403);
    }

    public function testCreateViewUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->get(route('campus.create'));
        $response->assertStatus(200);
    }

    public function testStoreRequiresAuthentication()
    {
        $response = $this->post(route('campus.store'), []);
        $response->assertRedirect(route('login'));
    }

    public function testStoreRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->post(route('campus.store'), []);
        $response->assertStatus(403);
    }

    public function testStoreUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->post(route('campus.store'), $this->data);
        $response->assertRedirect(route('campus.index'));
        $this->assertDatabaseHas('campuses', ['name' => $this->data['name']]);
    }

    public function testEditViewRequiresAuthentication()
    {
        $response = $this->get(route('campus.edit', $this->campus->id));
        $response->assertRedirect(route('login'));
    }

    public function testEditViewRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->get(route('campus.edit', $this->campus->id));
        $response->assertStatus(403);
    }

    public function testEditViewUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->get(route('campus.edit', $this->campus->id));
        $response->assertStatus(200);
    }

    public function testEditViewReturns404ForNonExistingCampus()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->get(route('campus.edit', $this->nonExistingId)); 
        $response->assertStatus(404);
    }

    public function testUpdateRequiresAuthentication()
    {
        $response = $this->put(route('campus.update', $this->campus->id), []);
        $response->assertRedirect(route('login'));
    }

    public function testUpdateRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->put(route('campus.update', $this->campus->id), []);
        $response->assertStatus(403);
    }

    public function testUpdateUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->put(route('campus.update', $this->campus->id), $this->data);
        $response->assertRedirect(route('campus.index'));
        $this->assertDatabaseHas('campuses', ['id' => $this->campus->id, 'name' => 'Campus Teste 2']);
    }

    public function testUpdateReturns404ForNonExistingCampus()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->put(route('campus.update', $this->nonExistingId), $this->data);
        $response->assertStatus(404);
    }

    public function testDestroyRequiresAuthentication()
    {
        $response = $this->delete(route('campus.destroy', $this->campus->id));
        $response->assertRedirect(route('login'));
    }

    public function testDestroyRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->delete(route('campus.destroy', $this->campus->id));
        $response->assertStatus(403);
    }

    public function testDestroyUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->delete(route('campus.destroy', $this->campus->id));
        $response->assertRedirect(route('campus.index'));
        $this->assertDatabaseHas('campuses', ['id' => $this->campus->id, 'active' => false]);
    }

    public function testDestroyReturns404ForNonExistingCampus()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->delete(route('campus.destroy', $this->nonExistingId));
        $response->assertStatus(404);
    }
}
