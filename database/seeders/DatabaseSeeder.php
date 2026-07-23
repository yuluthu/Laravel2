<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant = Tenant::factory()->create();
        $location = Location::factory()->create([
            'name' => 'Avenue du Président René Coty',
        ]);

        $user = User::factory()->for($tenant)->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
        ]);

        $product = Product::factory()->create();

        // devices that have a subscription but no order
        Device::factory()
            ->count(2)
            ->for($tenant)
            ->for($location)
            ->for($product)
            ->hasSubscription()
            ->hasDeviceLogs(2)
            ->create();

        // sub and order
        Device::factory()
            ->count(5)
            ->for($tenant)->for($location)->for($product)
            ->hasSubscription()
            ->hasOrder()
            ->hasDeviceLogs(2)
            ->create();

        // neither
        Device::factory()
            ->count(3)
            ->for($tenant)->for($location)->for($product)
            ->hasDeviceLogs(2)
            ->create();

        // just an order
        Device::factory()
            ->count(3)
            ->for($tenant)
            ->for($location)
            ->for($product)
            ->hasOrder()
            ->hasDeviceLogs(
                [
                    'battery_charge' => 79,
                    'sensor_life' => 24,
                ], [
                    'battery_charge' => 33,
                    'sensor_life' => 29,
                ], [
                    'battery_charge' => 100,
                    'sensor_life' => 50,
                ],
            )
            ->create();

        $apiToken = $user->createToken('api');
        $this->command->info('API Token for sample user: '.$apiToken->plainTextToken);

        $secondTenant = Tenant::factory()->create();
        $secondLocation = Location::factory()->create([
            'name' => 'Avenue du Président René Coty',
        ]);

        // a device for the second tenant that the first user should not be able to access
        $secondTenantDevice = Device::factory()
            ->for($secondTenant)
            ->for($secondLocation)
            ->for($product)
            ->hasSubscription()
            ->hasDeviceLogs(2)
            ->create();

        $this->command->info('ID of inaccessible device: '.$secondTenantDevice->id);

    }
}
