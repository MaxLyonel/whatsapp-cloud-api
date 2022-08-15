<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    public function markMessageAsRead() {
        $phone_number_id = config('app.phone_number_id');
        $version = config('app.version');
        $user_access_token = config('app.user_access_token');
        $response = Http::withToken($user_access_token)
            ->post('https://graph.facebook.com/'.$version.'/'.$phone_number_id.'/messages', [ 
                'messaging_product' => 'whatsapp',
                'status' => 'read',
                'message_id' => 'wamid.HBgLNTkxNjUxNDgxMjAVAgASGCA2Mjk3QjRFNkI5QjcwMzVGQTM1NENENzUyOUM2RUE1OQA='
            ]);

        // $respuesta = array();

        return $response->successful() ? 
            json_encode(['respuesta' => 'Mensaje leido']) : ($response->failed() ? 
            json_encode(['respuesta' => 'Error!']) : 
            json_encode(['respuesta' => 'Hubo un inconveniente']));
    }

    public function sendText(Request $request){
        // El frontend que tendría que enviarme?
        // - id del affiliado
        $phone_number_id = config('app.phone_number_id');
        $version = config('app.version');
        $user_access_token = config('app.user_access_token');
        
        logger('phone_number_id');
        logger($phone_number_id);
        logger('version');
        logger($version);
        logger('user_access_token');
        logger($user_access_token);

        $mensaje = 'estos son cabeceras';
        // $recipient_phone_number = '59165148120';
        $recipient_phone_number = $request->recipient_phone_number;

        $response = Http::withHeaders([ 'Content-Type' => 'application/json' ])
            ->withToken($user_access_token)
            ->acceptJson()
            ->post('https://graph.facebook.com/'.$version.'/'.$phone_number_id.'/messages', [ 
                'messaging_product' => 'whatsapp',
                'preview_url' => false,
                'recipient_type' => 'individual',
                'to' => $recipient_phone_number, 
                'type' => 'text',
                'text' => [
                    'body' => $mensaje
                ]
            ]);

        // return $response->headers();

        return $response->successful() ? 
            json_encode(['respuesta' => 'Mensaje enviado']) : ($response->failed() ? 
            json_encode(['respuesta' => 'Error al enviar']) : 
            json_encode(['respuesta' => 'Hubo un inconveniente']));

        // $response->throwIf($response->failed())->json();
        // $response->throwUnless($response->successful());
        // $env = env('PHONE_NUMBER_ID', 'algo');
        // logger($env);
        // logger($response->json());
        // return $response->json();
    }
}
