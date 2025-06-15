<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatGptController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\ResultadoPreguntaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DocenteSesionController;

Route::apiResource('clientes',ClienteController::class);
Route::apiResource('books',BookController::class);
Route::apiResource('orders',OrderController::class);
Route::apiResource('details',DetailController::class);

Route::apiResource('alumnos',AlumnoController::class);
Route::apiResource('instituciones',InstitucionController::class);
Route::apiResource('cursos',CursoController::class);
Route::apiResource('temas',TemaController::class);
Route::apiResource('evaluaciones',EvaluacionController::class);
Route::apiResource('secciones',SeccionController::class);
Route::apiResource('resultados',ResultadoPreguntaController::class);
Route::apiResource('preguntas',PreguntaController::class);
Route::apiResource('usuarios',UsuarioController::class);
Route::apiResource('docentes',DocenteController::class);
Route::apiResource('docentesesions',DocenteSesionController::class);

Route::post('/chatgpt', [ChatGptController::class, 'chat']);
