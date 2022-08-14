<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    public function index(){
        $env = env('PHONE_NUMBER_ID', 'algo');
        logger($env);
        // Lo primero que tengo que hacer es armar la ruta de whatsapp

        // EL flujo será que daré una ruta al frontend, la cual dentro de su controlador
        // consumira otra ruta que será la de whatsapp cloud api

        // Authorization => el token de usuario
        // Phone-Number-ID => el id del teléfono emisor
        // Recipient-Phone-Number => el número del receptor cel
        // Version => version (v13.0)
        $response = Http::withHeaders([
            'Authorization' => 'Bearer EAAYUWHvv1U4BAFB1WB9Frnm3P8F5bBT4qFJk2VZBAUxnRXUlVeYDgKmSvs17f7ZAtBnqG6ZBDjwBpvIqEDUcno1mUhwwGPZCl4UOQn7yx8qkIGyb2Kxynzgp0ANqm0uqeqZA3ZBqQ2SHWYpPfu7NnbXwT3hj2sZBpvWPdpqCaU257piOCP1IGlTSNeoijZAZAtrQno1bvq3iUYIqumYZCHNSM2',
            'Accept' => '*/*',
            'Content-Type' => 'application/json'
        ])->post('https://graph.facebook.com/v13.0/105941555563167/messages', [ 
            'messaging_product' => 'whatsapp',
            'preview_url' => false,
            'recipient_type' => 'individual',
            'to' => '59165148120', 
            'type' => 'text',
            'text' => ['body' => 'hola desde la API no funciona']
        ]);
        // logger($response->json());

        return $response->json();

    }
}
