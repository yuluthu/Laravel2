<?php

namespace App\Http\Controllers;

use App\Http\Requests\TelemetryUpdateRequest;
use App\Models\Device;
use App\Models\DeviceLog;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deviceList = Device::all();

        return $deviceList;
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return $device;
    }

    public function status(Device $device)
    {
        return [
            'id' => $device->id,
            'product' => $device->product->name,
            'location' => $device->location->name,
            'subscription' => ! empty($device->subscription),
            'order' => $device->order,
            'battery_charge' => $device->currentStatus->battery_charge,
            'sensor_life' => $device->currentStatus->sensor_life,
            'last_update' => $device->currentStatus->created_at,
        ];
    }

    public function updateTelemetry(TelemetryUpdateRequest $request, Device $device)
    {
        DeviceLog::factory()->create([
            'device_id' => $device->id,
            'battery_charge' => $request->input('data.battery_charge'),
            'sensor_life' => $request->input('data.sensor_life'),
        ]);

        return $device->refresh();
    }
}
