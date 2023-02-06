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
                'message_id' => 'wamid.HBgLNTkxNjUxNDgxMjAVAgASGCBCRDIyRDNFNTNFODlBNTc4MTE4QzE2NzYxNzBBNTVCRAA='
            ]);

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
        
        $mensaje = 'estos son cabeceras';
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

        return $response->successful() ? 
            json_encode(['respuesta' => 'Mensaje enviado']) : ($response->failed() ? 
            json_encode(['respuesta' => 'Error al enviar']) : 
            json_encode(['respuesta' => 'Hubo un inconveniente']));

    }

    public function sendMessageTemplateText(Request $request) {
        $user_access_token = config('app.user_access_token');
        $phone_number_id = config('app.phone_number_id');
        $version = config('app.version');
        $recipient_phone_number = $request->recipient_phone_number;
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withToken($user_access_token)
            ->acceptJson()
            ->post('https://graph.facebook.com/'.$version.'/'.$phone_number_id.'/messages', [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $recipient_phone_number,
                'type' => 'template',
                'template' => [
                    'name' => 'saludo_muserpol', // nombre de la plantilla
                    'language' => [
                        'code' => 'es_MX' // lenguaje que fue construido
                    ],
                    'components' => [
                        [
                            'type' => 'body', // en donde se requiere los parámetros? Responde a eso esta propiedad
                            'parameters' => [ // los parametros son los que establecemos en la plantilla
                                [
                                    'type' => 'text',
                                    'text' => 'Leonel Vargas'
                                ]
                            ],
                            /*[ // esto no funciona xq? porque mi plantilla no tiene un boton
                                'type' => 'button',
                                'sub_type' => 'quick_reply',
                                'index' => 0, 
                                'parameters' => [
                                    [
                                        'type' => 'payload',
                                        'payload' => 'PAYLOAD'
                                    ]
                                ]
                            ]*/

                        ]
                    ]

                ]
            ]);
        if($response->successful()) {
            return response()->json(['message' => 'Todo fue exitoso', 'success' => json_decode($response->body())]);
        }
        else return response()->json(['message' => 'algo salio mal', 'error' => json_decode($response->body())]);
    }

    public function sendMessageTemplateMultiMedia(Request $request) {
        $user_access_token = config('app.user_access_token');
        $phone_number_id = config('app.phone_number_id');
        $version = config('app.version');
        $recipient_phone_number = $request->recipient_phone_number;
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withToken($user_access_token)
            ->acceptJson()
            ->post('https://graph.facebook.com/'.$version.'/'.$phone_number_id.'/messages', [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $recipient_phone_number,
                'type' => 'template',
                'template' => [
                    'name' => 'sample_movie_ticket_confirmation',
                    'language' => [
                        'code' => 'es',
                        'policy' => 'deterministic'
                    ],
                    'components' => [
                        [
                            'type' => 'header',
                            'parameters' => [
                                [
                                    'type' => 'image',
                                    'image' => [
                                        'link' => 'https://www.opinion.com.bo/asset/thumbnail,992,558,center,center/media/opinion/images/2022/05/24/2022052415283420630.jpg'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'body',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Leonel Vargas',
                                ],
                                [
                                    'type' => 'text',
                                    'text' => '12:30',
                                ],
                                [
                                    'type' => 'text',
                                    'text' => 'La Paz'
                                ],
                                [
                                    'type' => 'text',
                                    'text' => 'centrales'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        if($response->successful()) {
            return response()->json(['success' => json_decode($response->body())]);
        }
        else return response()->json(['error' => json_decode($response->body())]);

    }

    public function test() {
        $user_access_token = config('app.user_access_token');
        $phone_number_id = config('app.phone_number_id');
        $version = config('app.version');
        // return response()->json([

        // ])
        // return response()->json([
        //     'components' => [
        //         [
        //             'type' => 'header',
        //             'paramter' => [
        //                 [
        //                     'type' => 'image',
        //                     'image' => [
        //                         'link' => 'http(s)://URL'
        //                     ]
        //                 ]
        //             ]
        //         ],
        //         [
        //             'type' => 'body',
        //             'parameter' => [
        //                 [
        //                     'type' => 'text',
        //                     'text' => 'TEXT_STRING'
        //                 ]
        //             ]
        //         ]
        //     ]
        // ]);
    }
}
