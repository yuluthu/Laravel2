<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TelemetryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'requestType' => 'required|in:telemetryUpdate',
            'data' => 'required',
            'data.battery_charge' => 'required|numeric|between:0,100',
            'data.sensor_life' => 'required|numeric|between:0,100',
        ];
    }
}
