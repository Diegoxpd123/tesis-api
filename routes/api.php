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
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ResultadoPreguntaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DocenteSesionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\ImagenProductoController;


Route::apiResource('clientes',ClienteController::class);
Route::apiResource('books',BookController::class);
Route::apiResource('orders',OrderController::class);
Route::apiResource('details',DetailController::class);
Route::apiResource('productos',ProductoController::class);
Route::post('/whatsapp/enviar-boleta-falsa', [WhatsappController::class, 'enviarBoletaFalsa']);

Route::get('/imagenes-productos', [ImagenProductoController::class, 'listar']);

Route::post('/resultados-curso', [AlumnoController::class, 'getResultadosCurso']);
Route::post('/reporte-detallado', [AlumnoController::class, 'getReporteDetallado']);
Route::post('/reporte-uso-por-curso', [AlumnoController::class, 'getReporteUsoPorCurso']);

Route::apiResource('empleados', EmpleadoController::class);
Route::apiResource('alumnos',AlumnoController::class);
Route::get('/alumnos-con-usuario', [AlumnoController::class, 'getAlumnosConUsuario']);
Route::post('/alumnos/create', [AlumnoController::class, 'createAlumno']);
Route::apiResource('instituciones',InstitucionController::class);
Route::apiResource('cursos',CursoController::class);
Route::apiResource('temas',TemaController::class);
Route::apiResource('evaluaciones',EvaluacionController::class);
Route::apiResource('secciones',SeccionController::class);
Route::apiResource('resultados',ResultadoPreguntaController::class);
Route::apiResource('preguntas',PreguntaController::class);
Route::apiResource('usuarios',UsuarioController::class);
Route::post('/usuarios/create', [UsuarioController::class, 'createUsuario']);
Route::post('/usuarios/login', [UsuarioController::class, 'login']);
Route::post('/usuarios/verify', [UsuarioController::class, 'verifyUser']);
Route::post('/usuarios/verify-dni', [UsuarioController::class, 'verifyDNI']);
Route::post('/usuarios/change-password', [UsuarioController::class, 'changePassword']);
Route::apiResource('docentes',DocenteController::class);
Route::apiResource('docentesesions',DocenteSesionController::class);

// Rutas específicas para docentes
Route::post('/docentes/secciones', [DocenteController::class, 'getSeccionesDocente']);
Route::post('/docentes/estudiantes', [DocenteController::class, 'getEstudiantesPorDocente']);

Route::post('/chatgpt', [ChatGptController::class, 'chat']);
