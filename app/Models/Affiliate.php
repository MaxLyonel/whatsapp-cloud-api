<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    public function cualquier_otro_metodo(){
        // El segundo argumento del método, debe ir el foreign_key 
        // de la clase relacionada, ósea (Phone)
        return $this->hasOne(Phone::class, 'affiliate_id');
    }
}
