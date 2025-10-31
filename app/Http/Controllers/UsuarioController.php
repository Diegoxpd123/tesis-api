<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class UsuarioController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $usuarios = Usuario::latest()->get();

        return response()->json($usuarios, Response::HTTP_OK);

    }
    //
    public function store(SaveUsuarioRequest $request): JsonResponse
    {

        $usuario = Usuario::create($request->validated());

        return response()->json($usuario, Response::HTTP_CREATED);

    }

    /**
     * Crear usuario con contraseña encriptada
     */
    public function createUsuario(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuarios,usuario',
            'numero' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'tipousuarioid' => 'required|integer',
            'aludocenid' => 'required|integer',
            'grado' => 'required|string|in:5,6',
            'is_actived' => 'integer',
            'is_deleted' => 'integer'
        ]);

        $usuario = Usuario::create([
            'usuario' => $request->usuario,
            'numero' => $request->numero,
            'contra' => bcrypt($request->password), // Encriptar contraseña
            'tipousuarioid' => $request->tipousuarioid,
            'aludocenid' => $request->aludocenid,
            'grado' => $request->grado,
            'is_actived' => $request->is_actived ?? 1,
            'is_deleted' => $request->is_deleted ?? 0
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'usuario' => $usuario
        ], Response::HTTP_CREATED);
    }

    /**
     * Verificar login con contraseña encriptada
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);

        $usuario = Usuario::where('usuario', $request->usuario)
            ->where('is_actived', 1)
            ->where('is_deleted', 0)
            ->first();

        if ($usuario && Hash::check($request->password, $usuario->contra)) {
            return response()->json([
                'success' => true,
                'message' => 'Login exitoso',
                'usuario' => [
                    'id' => $usuario->id,
                    'usuario' => $usuario->usuario,
                    'tipousuarioid' => $usuario->tipousuarioid,
                    'aludocenid' => $usuario->aludocenid,
                    'grado' => $usuario->grado,
                    'is_actived' => $usuario->is_actived,
                    'is_deleted' => $usuario->is_deleted
                ]
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ], Response::HTTP_UNAUTHORIZED);
    }
    //
    public function show(string $id): JsonResponse
    {
        $usuario = Usuario::findOrFail($id);

        return response()->json($usuario, Response::HTTP_OK);

    }
    //
    public function update(SaveUsuarioRequest $request, string $id): JsonResponse
    {

        $usuario = Usuario::findOrFail($id);

        $usuario->update($request->validated());

        return response()->json($usuario, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $usuario = Usuario::findOrFail($id);

        $usuario->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }

    /**
     * Verificar si el usuario existe para recuperación de contraseña
     */
    public function verifyUser(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => 'required|string'
        ]);

        $usuario = Usuario::where('usuario', $request->usuario)
            ->where('is_actived', 1)
            ->where('is_deleted', 0)
            ->first();

        if ($usuario) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario encontrado',
                'usuario' => [
                    'id' => $usuario->id,
                    'usuario' => $usuario->usuario,
                    'tipousuarioid' => $usuario->tipousuarioid,
                    'aludocenid' => $usuario->aludocenid,
                    'grado' => $usuario->grado
                ]
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Verificar los últimos 4 dígitos del DNI
     */
    public function verifyDNI(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer',
            'dni' => 'required|string|size:4'
        ]);

        $usuario = Usuario::find($request->user_id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        // Verificar que el usuario tenga un número de documento
        if (!$usuario->numero) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró información del documento'
            ], Response::HTTP_NOT_FOUND);
        }

        // Verificar los últimos 4 dígitos del DNI
        $lastFourDigits = substr($usuario->numero, -4);

        if ($lastFourDigits === $request->dni) {
            return response()->json([
                'success' => true,
                'message' => 'DNI verificado correctamente'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Los últimos 4 dígitos del DNI no coinciden'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Cambiar la contraseña del usuario
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer',
            'new_password' => 'required|string|min:6'
        ]);

        $usuario = Usuario::find($request->user_id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $usuario->update([
            'contra' => bcrypt($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contraseña cambiada exitosamente'
        ], Response::HTTP_OK);
    }
}
