<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Campus;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    
    protected $campus;
    protected $data;
    protected $event;
    protected $nonExistingId;
    protected $userNoPermission;
    protected $userWithPermission;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

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

        $this->userNoPermission = User::factory()->create();

        $this->userWithPermission = User::whereHas('roles', function ($query) {
            $query->where('name', 'Diretor');
        })->first();

        $this->nonExistingId = 999999;

        $this->event = Event::create([
            'name' => 'Evento Teste',
            'campus_id' => $this->campus->id,
            'event_date' => Carbon::tomorrow()->toDateString(),
            'event_time' => '14:30:00',
            'creator_id' => $this->userWithPermission->id,
        ]);

        $this->data = [
            'name' => 'Evento Teste 2',
            'campus_id' => $this->campus->id,
            'event_date' => Carbon::tomorrow()->toDateString(),
            'event_time' => '16:00:00',
        ];
    }

    public function testEventIndexView()
    {
        $response = $this->get(route('event.index'));
        $response->assertStatus(200);
    }

    public function testShowViewReturnsEventData()
    {
        $response = $this->get(route('event.show', $this->event->id));
        $response->assertStatus(200);
    }

    public function testShowViewReturns404ForNonExistingEvent()
    {
        $response = $this->get(route('event.show', $this->nonExistingId));
        $response->assertStatus(404);
    }

    public function testCreateViewRedirectUnauthenticatedUser()
    {
        $response = $this->get(route('event.create'));
        $response->assertRedirect(route('login'));
    }

    public function testCreateViewRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->get(route('event.create'));
        $response->assertStatus(403);
    }

    public function testCreateViewUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->get(route('event.create'));
        $response->assertStatus(200);
    }

    public function testStoreRequiresAuthentication()
    {
        $response = $this->post(route('event.store'), []);
        $response->assertRedirect(route('login'));
    }

    public function testStoreRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->post(route('event.store'), []);
        $response->assertStatus(403);
    }

    public function testStoreUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->post(route('event.store'), $this->data);
        $response->assertRedirect(route('event.index'));
        $this->assertDatabaseHas('events', ['name' => $this->data['name']]);
    }

    public function testEditViewRequiresAuthentication()
    {
        $response = $this->get(route('event.edit', $this->event->id));
        $response->assertRedirect(route('login'));
    }

    public function testEditViewRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->get(route('event.edit', $this->event->id));
        $response->assertStatus(403);
    }

    public function testEditViewUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->get(route('event.edit', $this->event->id));
        $response->assertStatus(200);
    }

    public function testEditViewReturns404ForNonExistingEvent()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->get(route('event.edit', $this->nonExistingId)); 
        $response->assertStatus(404);
    }

    public function testUpdateRequiresAuthentication()
    {
        $response = $this->put(route('event.update', $this->event->id), []);
        $response->assertRedirect(route('login'));
    }

    public function testUpdateRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->put(route('event.update', $this->event->id), []);
        $response->assertStatus(403);
    }

    public function testUpdateUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->put(route('event.update', $this->event->id), $this->data);
        $response->assertRedirect(route('event.index'));
        $this->assertDatabaseHas('events', ['id' => $this->event->id, 'name' => 'Evento Teste 2']);
    }

    public function testUpdateReturns404ForNonExistingEvent()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->put(route('event.update', $this->nonExistingId), $this->data); 
        $response->assertStatus(404);
    }

    public function testDestroyRequiresAuthentication()
    {
        $response = $this->delete(route('event.destroy', $this->event->id));
        $response->assertRedirect(route('login'));
    }

    public function testDestroyRequiresPermission()
    {
        $this->actingAs($this->userNoPermission);
        $response = $this->delete(route('event.destroy', $this->event->id));
        $response->assertStatus(403);
    }

    public function testDestroyUserWithPermissionCanAccess()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->delete(route('event.destroy', $this->event->id));
        $response->assertRedirect(route('event.index'));
        $this->assertDatabaseHas('events', ['id' => $this->event->id, 'active' => false]);
    }

    public function testDestroyReturns404ForNonExistingEvent()
    {
        $this->actingAs($this->userWithPermission);
        $response = $this->delete(route('event.destroy', $this->nonExistingId));
        $response->assertStatus(404);
    }
}
