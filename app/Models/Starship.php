<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Starship extends Model
{

    protected $table = 'starships';

    protected $primaryKey = 'starship_id';

    protected $fillable = [
        'name',
        'model',
        'starship_class',
        'cost_in_credits',
        'manufacturer',
    ];

    public function pilots()
{
    //return $this->belongsToMany(Pilot::class);
    return $this->belongsToMany(
        Pilot::class,
        'pilot_starship',
        'starship_id',
        'pilot_id'
    );
}
}
