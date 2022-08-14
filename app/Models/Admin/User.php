<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Si queremos vincular nuestro modelo con una tabla 
    // de diferente nombre a las convenciones de laravel
    protected $table = 'user_app';

    // Si no queremos usar el id como clave primaria por 
    // defecto de laravel, podemos especificar el PK
    protected $primaryKey = 'identity_card';

    // Si nuestro campo escogido como clave primaria no
    // es incremental, podemos desactivar esta caracterís-
    // tica.
    public $incrementing = false;

    // Si nuestra clave primaria no es de tipo entero, 
    // entonces debemos definir el tipo a string.
    protected $keyType = 'string';

    // De forma predeterminada Eloquent espera que existan
    // los campos created_at y updated_at
    public $timestamps = false; // desactivar

    // Establecer el formato de las marcas de tiempo
    protected $dateFormat = 'U';

    // Personalizar los nombres de los campos de timestamps
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';

    // Valores predeterminados para los atributos del modelo
    // protected $attributes = [
    //     'delayed' => false,
    // ];
}
