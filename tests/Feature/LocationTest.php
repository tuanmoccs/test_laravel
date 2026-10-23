<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Database\Seeders\LocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(LocationSeeder::class);
        $this->user = User::factory()->create();
    }

    public function test_index_and_api_return_paginated_data(): void
    {
        $this->actingAs($this->user)->get('/locations')->assertOk();

        $this->actingAs($this->user)
            ->getJson('/api/locations?draw=1&start=0&length=10&search[value]=Kampong&order[0][column]=1&order[0][dir]=asc&columns[1][data]=name')
            ->assertOk()
            ->assertJsonPath('draw', 1)
            ->assertJsonPath('recordsTotal', 75)
            ->assertJsonCount(10, 'data');
    }

    public function test_api_requires_auth(): void
    {
        $this->getJson('/api/locations')->assertUnauthorized();
    }

    public function test_crud(): void
    {
        $this->actingAs($this->user)->post('/locations', [
            'name' => 'Test Place', 'lat' => '1.5', 'lng' => '103.5', 'status' => 'active',
        ])->assertRedirect('/locations');

        $location = Location::where('name', 'Test Place')->firstOrFail();

        $this->actingAs($this->user)->get("/locations/{$location->id}/edit")->assertOk();
        $this->actingAs($this->user)->put("/locations/{$location->id}", [
            'name' => 'Test Place 2', 'lat' => '1.6', 'lng' => '103.6', 'status' => 'suspended',
        ])->assertRedirect('/locations');
        $this->assertSame('Test Place 2', $location->fresh()->name);

        $this->actingAs($this->user)->deleteJson("/locations/{$location->id}")->assertOk();
        $this->assertSoftDeleted($location);
    }

    public function test_validation(): void
    {
        $this->actingAs($this->user)->post('/locations', [
            'name' => 'Singapore', 'lat' => '200', 'lng' => 'abc', 'status' => 'unknown',
        ])->assertSessionHasErrors(['name', 'lat', 'lng', 'status']);
    }

    public function test_reset_command_restores_csv_data(): void
    {
        Location::query()->limit(10)->delete();
        Location::create(['name' => 'Extra', 'lat' => '1', 'lng' => '1']);

        $this->artisan('locations:reset')->assertSuccessful();

        $this->assertSame(75, Location::withTrashed()->count());
        $this->assertDatabaseMissing('locations', ['name' => 'Extra']);
    }
}
