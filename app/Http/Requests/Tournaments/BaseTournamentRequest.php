<?php

namespace App\Http\Requests\Tournaments;

use Illuminate\Foundation\Http\FormRequest;

class BaseTournamentRequest extends FormRequest
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
            'data.name' => [
                'required',
                'between:5,255',
                'unique:tournaments,name',
            ],
        ];
    }

    public function messages()
    {
        return [
            'data.name' => 'Another tournament with that name already exists',
            'data.name.between' => 'Tournament name must be between :min and :max characters',
        ];
    }
}
