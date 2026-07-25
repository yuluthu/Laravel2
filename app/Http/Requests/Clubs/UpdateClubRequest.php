<?php

namespace App\Http\Requests\Clubs;

class UpdateClubRequest extends BaseClubRequest
{
    public const REQUEST_TYPE = 'updateClub';

    public function authorize(): bool
    {
        return true;
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
