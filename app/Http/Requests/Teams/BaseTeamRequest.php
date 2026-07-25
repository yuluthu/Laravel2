<?php

namespace App\Http\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseTeamRequest extends FormRequest
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
                $this->team ? Rule::unique('teams', 'name')->ignore($this->team->id) : 'unique:teams,name',
            ],
            'data.club' => 'sometimes'.(! $this->team ? '|required' : '').'|integer',
        ];
    }

    public function messages()
    {
        return [
            'data.name' => 'Another team with that name already exists',
            'data.name.between' => 'Team name must be between :min and :max characters',
            'data.club' => 'Teams must have a club they belong to',
        ];
    }
}
