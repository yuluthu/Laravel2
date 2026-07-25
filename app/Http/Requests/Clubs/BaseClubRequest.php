<?php

namespace App\Http\Requests\Clubs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseClubRequest extends FormRequest
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
                $this->club ? Rule::unique('clubs', 'name')->ignore($this->club->id) : 'unique:clubs,name',
            ],
            'data.clubType' => 'sometimes|required|integer',
        ];
    }

    public function messages()
    {
        return [
            'data.name' => 'Another club with that name already exists',
            'data.name.between' => 'Club name must be between :min and :max characters',
            'data.clubType.required' => 'No club type was specified',
        ];
    }
}
