<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Detail;
use App\Models\Producto;
use App\Models\Cliente;

class WhatsappController extends Controller
{

public function enviarBoletaFalsa(Request $request)
{
    $empresa = $request->input('empresa', '🛍️ Tienda de Ropa');
    $telefono = '51' . preg_replace('/\D/', '', $request->input('telefono', '986837233'));
    $productos = $request->input('productos', []);
    $total = $request->input('total', 0);

    $mensaje = "📦 *BOLETA DE COMPRA (No válida)*\n\n";
    $mensaje .= "*Empresa:* $empresa\n";
    $mensaje .= "*Productos:*\n";

    foreach ($productos as $prod) {
        $mensaje .= "👕 {$prod['nombre']} x{$prod['cantidad']} - S/ " . number_format($prod['precio'], 2) . "\n";
    }

    $mensaje .= "\n💰 *Total: S/ " . number_format($total, 2) . "*";
    $mensaje .= "\n\nGracias por su compra. 🧾";

    // Configura UltraMsg
    $instanceId = 'instance127376'; // Tu instancia UltraMsg
    $token = 'qdwbzpk855c6qoe3';     // Tu token de acceso

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => "Bearer $token"
    ])->post("https://api.ultramsg.com/$instanceId/messages/chat", [
        "to" => $telefono,
        "body" => $mensaje,
        "priority" => 10,
        "referenceId" => "boleta_fake_" . uniqid()
    ]);

    return response()->json([
        'mensaje_enviado' => true,
        'whatsapp_response' => $response->json()
    ]);
}

}
