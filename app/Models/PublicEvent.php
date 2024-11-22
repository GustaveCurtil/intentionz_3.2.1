<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicEvent extends Model
{
    protected $fillable = [
        'user_id',
        'titel',
        'datum', 
        'tijd',
        'adres', 
        'stad', 
        'url_locatie', 
        'categorie', 
        'url_evenement',
        'beschrijving', 
        'kleur',
        'achtergrond_pad', 
        'foto_pad', 
        'zoom', 
        'verticaal',
        'horizontaal', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}