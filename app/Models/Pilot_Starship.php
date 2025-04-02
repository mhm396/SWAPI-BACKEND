<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot_Starship extends Model
{

    protected $table = 'pilot_starship'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'pilot_id',
        'starship_id',
    ];
}
