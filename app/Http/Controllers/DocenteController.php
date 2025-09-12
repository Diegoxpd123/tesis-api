<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDocenteRequest;
use App\Models\Docente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class DocenteController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $docentes = Docente::latest()->get();

        return response()->json($docentes, Response::HTTP_OK);

    }
    //
    public function store(SaveDocenteRequest $request): JsonResponse
    {

        $docente = Docente::create($request->validated());

        return response()->json($docente, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $docente = Docente::findOrFail($id);

        return response()->json($docente, Response::HTTP_OK);

    }
    //
    public function update(SaveDocenteRequest $request, string $id): JsonResponse
    {

        $docente = Docente::findOrFail($id);

        $docente->update($request->validated());

        return response()->json($docente, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $docente = Docente::findOrFail($id);

        $docente->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }

    /**
     * Obtener las secciones asignadas a un docente
     */
    public function getSeccionesDocente(Request $request): JsonResponse
    {
        $docenteId = $request->input('docente_id');

        if (!$docenteId) {
            return response()->json(['error' => 'docente_id es requerido'], 400);
        }

        $secciones = DB::select("
            SELECT DISTINCT s.id, s.nombre, s.institucionid
            FROM secciones s
            INNER JOIN docentessesiones ds ON ds.seccionid = s.id
            WHERE ds.docenteid = ?
            AND ds.is_deleted = 0
            AND ds.is_actived = 1
            AND s.is_deleted = 0
            AND s.is_actived = 1
        ", [$docenteId]);

        return response()->json($secciones, Response::HTTP_OK);
    }

    /**
     * Obtener estudiantes de las secciones asignadas a un docente
     */
    public function getEstudiantesPorDocente(Request $request): JsonResponse
    {
        $docenteId = $request->input('docente_id');

        if (!$docenteId) {
            return response()->json(['error' => 'docente_id es requerido'], 400);
        }

        $estudiantes = DB::select("
            SELECT DISTINCT
                a.id,
                a.nombre,
                a.grado,
                a.seccionid,
                s.nombre as seccion_nombre,
                u.usuario,
                u.id as usuario_id
            FROM alumnos a
            INNER JOIN usuarios u ON u.aludocenid = a.id
            INNER JOIN secciones s ON s.id = a.seccionid
            INNER JOIN docentessesiones ds ON ds.seccionid = s.id
            WHERE ds.docenteid = ?
            AND u.tipousuarioid = 1
            AND a.is_deleted = 0
            AND a.is_actived = 1
            AND u.is_deleted = 0
            AND u.is_actived = 1
            AND ds.is_deleted = 0
            AND ds.is_actived = 1
            ORDER BY a.nombre
        ", [$docenteId]);

        // Calcular porcentajes para cada estudiante
        foreach ($estudiantes as $estudiante) {
            // Contar respuestas correctas
            $respuestasCorrectas = DB::select("
                SELECT COUNT(*) as total
                FROM resultadospreguntas rp
                WHERE rp.alumnoid = ?
                AND rp.respuesta = 'correcta'
                AND rp.is_deleted = 0
            ", [$estudiante->id]);

            // Contar total de respuestas
            $totalRespuestas = DB::select("
                SELECT COUNT(*) as total
                FROM resultadospreguntas rp
                WHERE rp.alumnoid = ?
                AND rp.is_deleted = 0
            ", [$estudiante->id]);

            $correctas = $respuestasCorrectas[0]->total ?? 0;
            $total = $totalRespuestas[0]->total ?? 0;

            $estudiante->respuestas_correctas = $correctas;
            $estudiante->total_respuestas = $total;
            $estudiante->porcentaje = $total > 0 ? round(($correctas / $total) * 100) : 0;
        }

        return response()->json($estudiantes, Response::HTTP_OK);
    }

}
