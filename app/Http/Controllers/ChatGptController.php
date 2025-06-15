<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatGptController extends Controller
{
    public function chat(Request $request)
    {
        try {
            $client = new Client();

            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' =>  'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $request->input('messages')]
                    ],
                ]
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $error = json_decode($e->getResponse()->getBody(), true);

            return response()->json([
                'error' => $error['error']['message'] ?? 'Error desconocido',
            ], $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error del servidor: ' . $e->getMessage(),
            ], 500);
        }
    }
}
