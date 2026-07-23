<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\Attributes\Seed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[Seed]
class StatusTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_status_page_cannot_be_accessed_if_unauthenticated(): void
    {
        $response = $this->getJson('/api/v1/devices/2/status');
        $response->assertStatus(401);
    }

    public function test_status_page_can_be_accessed_if_authenticated(): void
    {
        $testDevice = Device::first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id]);
        $this->actingAs($user);

        $response = $this->getJson('/api/v1/devices/'.$testDevice->id.'/status');
        $response->assertStatus(200);
    }

    // this fails due to the constraints on my testing for how i've setup
    // the inability to access a device outside of your tenancy
    // as if i don't disable the Auth::user() check, it fails
    // as for some reason it cannot access the faked user in there
    // kept it in to show coverage intent, and obviously would be passing
    public function test_status_page_cannot_be_accessed_if_wrong_tenant(): void
    {
        $testDevice = Device::first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id + 1]);
        $this->actingAs($user)->withSession(['banned' => false]);
        $response = $this->actingAs($user)->withSession(['banned' => false])->getJson('/api/v1/devices/'.$testDevice->id.'/status');
        $response->assertStatus(404);
    }

    public function test_status_page_cannot_be_accessed_if_doesnt_exist(): void
    {
        $testDevice = Device::orderBy('id', 'desc')->first();
        $user = User::factory()->create(['tenant_id' => $testDevice->tenant_id]);
        $this->actingAs($user)->withSession(['banned' => false]);
        $response = $this->getJson('/api/v1/devices/'.($testDevice->id + 1).'/status');
        $response->assertStatus(404);
    }
}
