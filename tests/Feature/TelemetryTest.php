<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\Attributes\Seed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[Seed]
class TelemetryTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_telemetry_page_cannot_be_accessed_if_unauthenticated(): void
    {
        $testDevice = Device::first();
        $response = $this->postJson('/api/v1/devices/'.$testDevice->id.'/telemetry', [
            'requestType' => 'telemetryUpdate',
            'data' => [
                'battery_charge' => 32,
                'sensor_life' => 32,
            ],
        ]);
        $response = $this->postJson('/api/v1/devices/2/telemetry');
        $response->assertStatus(401);
    }

    public function test_telemetry_page_can_be_accessed_if_authenticated(): void
    {
        $testDevice = Device::first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id]);
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/devices/'.$testDevice->id.'/telemetry', [
            'requestType' => 'telemetryUpdate',
            'data' => [
                'battery_charge' => 32,
                'sensor_life' => 32,
            ],
        ]);
        $response->assertStatus(200);
    }

    // same as status tests
    public function test_telemetry_page_cannot_be_accessed_if_wrong_tenant(): void
    {
        $testDevice = Device::first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id + 1]);
        $this->actingAs($user);
        $response = $this->postJson('/api/v1/devices/'.$testDevice->id.'/telemetry', [
            'requestType' => 'telemetryUpdate',
            'data' => [
                'battery_charge' => 32,
                'sensor_life' => 32,
            ],
        ]);
        $response->assertStatus(404);
    }

    public function test_telemetry_page_cannot_be_accessed_if_doesnt_exist(): void
    {
        $testDevice = Device::orderBy('id', 'desc')->first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id]);
        $this->actingAs($user);
        $response = $this->postJson('/api/v1/devices/'.($testDevice->id + 1).'/telemetry', [
            'requestType' => 'telemetryUpdate',
            'data' => [
                'battery_charge' => 32,
                'sensor_life' => 32,
            ],
        ]);
        $response->assertStatus(404);
    }

    public function test_telemetry_page_cannot_be_accessed_if_data_incorrectly_formatted(): void
    {
        $testDevice = Device::orderBy('id', 'desc')->first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id]);
        $this->actingAs($user);
        $response = $this->postJson('/api/v1/devices/'.($testDevice->id).'/telemetry', [
            'requestType' => 'fubar',
            'data' => [
                'battery_charge' => 32,
                'sensor_life' => 32,
            ],
        ]);
        $response->assertStatus(422);

        $secondResponse = $this->postJson('/api/v1/devices/'.($testDevice->id).'/telemetry', [
            'requestType' => 'telemetryUpdate',
            'data' => [
                'battery_charge' => 'bundy',
                'sensor_life' => 32,
            ],
        ]);
        $secondResponse->assertStatus(422);
    }

    public function test_telemetry_page_cannot_be_accessed_if_data_not_supplied(): void
    {
        $testDevice = Device::orderBy('id', 'desc')->first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id]);
        $this->actingAs($user);
        $response = $this->postJson('/api/v1/devices/'.($testDevice->id).'/telemetry', [
            'requestType' => 'telemetryUpdate',
            'data' => [
                'sensor_life' => 32,
            ],
        ]);
        $response->assertStatus(422);
    }
}
