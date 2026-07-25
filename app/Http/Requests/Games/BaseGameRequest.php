<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    public const REQUEST_TYPE = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'requestType' => 'required|in:'.static::REQUEST_TYPE,
            'data' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
