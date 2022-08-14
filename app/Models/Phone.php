<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    // Si no quiero seguir las convenciones y quiero cambiar el nombre del método
    // debo hacer esto
    public function affiliate(){
        // El segundo argumento del método, es la clave foranea
        // del modelo actual (clase referenciada)
        // El withDefault nos arroja ese resultado cuando no hay relación entre este
        // modelo y la clase pasada al método belongsTo, no así cuando esta mal escri-
        // to el nombre del método 'cualquier_otro_metodo'
        return $this->belongsTo(Affiliate::class)->withDefault([
            'name' => 'Esta relación esta nula',
        ]);
        
        // return $this->belongsTo(User::class, 'affiliate_id')->withDefault( 
        //     function($user, $post){
        //         $user->name = 'Guest Author';
        //     }
        // );
    }
}
