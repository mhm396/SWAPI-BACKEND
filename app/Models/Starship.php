<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Starship extends Model
{

    protected $table = 'starships';

    protected $fillable = [
        'name',
        'model',
        'starship_class',
        'cost_in_credits',
        'manufacturer',
    ];
}
