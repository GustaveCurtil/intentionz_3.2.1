<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'device_id',
        'alias',
        'user_id',
        'ip_address',
        'kleur_achtergrond',
        'kleur_thema', 
        'kleur_thema2', 
        'kleur_thema3',
        'kleur_tekst'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
