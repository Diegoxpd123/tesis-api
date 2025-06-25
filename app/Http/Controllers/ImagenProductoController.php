<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class ImagenProductoController extends Controller
{
    public function listar()
    {
        $ruta = public_path('src/img/productos');

        if (!File::exists($ruta)) {
            return response()->json(['error' => 'Ruta no encontrada', 'ruta' => $ruta], 404);
        }

        $archivos = File::files($ruta);

        return response()->json([
            'ruta' => $ruta,
            'total_archivos' => count($archivos),
            'nombres' => array_map(fn($file) => $file->getFilename(), $archivos)
        ]);
    }
}
