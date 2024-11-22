<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $fillable = [
        'user_id',
        'adres',
        'stad',
        'url_locatie', 
        'url_website',
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
