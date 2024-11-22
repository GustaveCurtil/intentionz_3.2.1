<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateEvent extends Model
{
    protected $fillable = [
        'user_id',
        'titel',
        'datum', 
        'tijd',
        'adres', 
        'stad', 
        'url_locatie', 
        'beschrijving', 
        'achtergrond_pad', 
        'foto_pad', 
        'zoom', 
        'verticaal',
        'horizontaal', 
        'invitation_slug', 
    ];
}
