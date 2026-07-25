<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\TournamentFactory;

#[HasFactory]
class Tournament extends Model
{
    protected $table = 'tournaments';
    //
}
