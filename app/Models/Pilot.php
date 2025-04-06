<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    protected $table = 'pilots';

    protected $primaryKey = 'pilot_id';

    protected $fillable = [
        'name',
    ];

    public function starships()
{
    return $this->belongsToMany(
        Starship::class,
        'pilot_starship',
        'pilot_id',       
        'starship_id'
    );
}
}
