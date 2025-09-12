<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class AlumnoController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $alumnos = Alumno::latest()->get();

        return response()->json($alumnos, Response::HTTP_OK);

    }

    /**
     * Crear alumno
     */
    public function createAlumno(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'grado' => 'required|integer',
            'institucionid' => 'required|integer',
            'seccionid' => 'required|integer',
            'is_actived' => 'integer',
            'is_deleted' => 'integer'
        ]);

        $alumno = Alumno::create([
            'nombre' => $request->nombre,
            'numero' => $request->numero, // DNI del alumno
            'grado' => $request->grado,
            'institucionid' => $request->institucionid,
            'seccionid' => $request->seccionid,
            'correo' => '', // Valor por defecto
            'is_actived' => $request->is_actived ?? 1,
            'is_deleted' => $request->is_deleted ?? 0
        ]);

        return response()->json([
            'message' => 'Alumno creado exitosamente',
            'alumno' => $alumno
        ], Response::HTTP_CREATED);
    }

    /**
     * Obtener alumnos con su usuario_id asociado
     */
    public function getAlumnosConUsuario(): JsonResponse
    {
        $alumnos = DB::select("
            SELECT
                a.id,
                a.nombre,
                a.grado,
                a.seccionid,
                s.nombre as seccion_nombre,
                u.id as usuario_id,
                u.usuario,
                COALESCE(
                    (SELECT COUNT(*)
                     FROM resultadospreguntas rp
                     WHERE rp.alumnoid = a.id
                     AND rp.respuesta = 'correcta'
                     AND rp.is_deleted = 0
                    ), 0
                ) as respuestas_correctas,
                COALESCE(
                    (SELECT COUNT(*)
                     FROM resultadospreguntas rp
                     WHERE rp.alumnoid = a.id
                     AND rp.is_deleted = 0
                    ), 0
                ) as total_respuestas
            FROM alumnos a
            LEFT JOIN usuarios u ON u.aludocenid = a.id
            LEFT JOIN secciones s ON s.id = a.seccionid
            WHERE a.is_deleted = 0
            AND a.is_actived = 1
            AND (u.tipousuarioid = 1 OR u.tipousuarioid IS NULL)
            ORDER BY a.nombre
        ");

        // Calcular porcentajes
        foreach ($alumnos as $alumno) {
            if ($alumno->total_respuestas > 0) {
                $alumno->porcentaje = round(($alumno->respuestas_correctas / $alumno->total_respuestas) * 100);
            } else {
                $alumno->porcentaje = 0;
            }
        }

        return response()->json($alumnos, Response::HTTP_OK);
    }

    /**
     * Obtener reporte de uso por curso para administradores
     */
    public function getReporteUsoPorCurso(Request $request): JsonResponse
    {
        $usuarioid = $request->input('usuarioid');
        $cursoid = $request->input('cursoid');

        if (!$usuarioid || !$cursoid) {
            return response()->json(['error' => 'usuarioid y cursoid son requeridos'], 400);
        }

        // Obtener datos agrupados de 5 en 5 para exámenes
        $examenes = DB::select("
            SELECT
                u.id as usuario_id,
                u.usuario as nombre_usuario,
                a.id as alumno_id,
                a.nombre as nombre_alumno,
                a.grado,
                t.nombre AS tema,
                e.nombre AS evaluacion,
                e.id as evaluacion_id,
                p.id as pregunta_id,
                p.descripcion as pregunta,
                p.respuesta as respuesta_correcta,
                p.opcion1,
                p.opcion2,
                p.opcion3,
                p.opcion4,
                rp.respuesta as respuesta_seleccionada,
                rp.tiempo as tiempo_respuesta,
                rp.tiemporeforzamiento,
                rp.isexamen,
                rp.created_at as fecha_respuesta,
                CASE
                    WHEN rp.respuesta = 'correcta' THEN 'Correcta'
                    ELSE 'Incorrecta'
                END as estado_respuesta,
                FLOOR((ROW_NUMBER() OVER (ORDER BY rp.created_at) - 1) / 5) + 1 as grupo_examen
            FROM usuarios u
            INNER JOIN alumnos a ON a.id = u.aludocenid
            INNER JOIN resultadospreguntas rp ON rp.alumnoid = a.id
            INNER JOIN preguntas p ON p.id = rp.preguntaid
            INNER JOIN evaluaciones e ON e.id = p.evaluacionid
            INNER JOIN temas t ON t.id = e.temaid
            WHERE
                t.cursoid = ?
                AND u.id = ?
                AND rp.isexamen = 1
                AND rp.is_deleted = 0
            ORDER BY rp.created_at
        ", [$cursoid, $usuarioid]);

        // Obtener datos agrupados de 5 en 5 para prácticas (todas las respuestas por pregunta única)
        $practicas = DB::select("
            SELECT
                u.id as usuario_id,
                u.usuario as nombre_usuario,
                a.id as alumno_id,
                a.nombre as nombre_alumno,
                a.grado,
                t.nombre AS tema,
                e.nombre AS evaluacion,
                e.id as evaluacion_id,
                p.id as pregunta_id,
                p.descripcion as pregunta,
                p.respuesta as respuesta_correcta,
                p.opcion1,
                p.opcion2,
                p.opcion3,
                p.opcion4,
                rp.respuesta as respuesta_seleccionada,
                rp.tiempo as tiempo_respuesta,
                rp.tiemporeforzamiento,
                rp.isexamen,
                rp.created_at as fecha_respuesta,
                CASE
                    WHEN rp.respuesta = 'correcta' THEN 'Correcta'
                    ELSE 'Incorrecta'
                END as estado_respuesta,
                FLOOR((ROW_NUMBER() OVER (ORDER BY p.id, rp.created_at) - 1) / 5) + 1 as grupo_practica
            FROM usuarios u
            INNER JOIN alumnos a ON a.id = u.aludocenid
            INNER JOIN resultadospreguntas rp ON rp.alumnoid = a.id
            INNER JOIN preguntas p ON p.id = rp.preguntaid
            INNER JOIN evaluaciones e ON e.id = p.evaluacionid
            INNER JOIN temas t ON t.id = e.temaid
            WHERE
                t.cursoid = ?
                AND u.id = ?
                AND rp.isexamen = 0
                AND rp.is_deleted = 0
            ORDER BY p.id, rp.created_at
        ", [$cursoid, $usuarioid]);

        return response()->json([
            'examenes' => $examenes,
            'practicas' => $practicas
        ], Response::HTTP_OK);
    }


public function getResultadosCurso(Request $request)
{
    $cursoid = $request->input('cursoid');
    $usuarioid = $request->input('usuarioid');
    $fechainicio = $request->input('fechainicio');
    $fechafin = $request->input('fechafin');

    $resultados = DB::select("
        SELECT
            t.nombre AS tema,
            e.nombre AS evaluacion,
            CONCAT(
              SUM(CASE WHEN rp.respuesta = 'correcta' THEN 1 ELSE 0 END),
              '/',
              COUNT(rp.id)
            ) AS respuestas_buenas_sobre_totales,
            SUM(rp.tiempo) AS total_tiempo
        FROM temas AS t
        INNER JOIN evaluaciones AS e ON e.temaid = t.id
        INNER JOIN preguntas AS p ON p.evaluacionid = e.id
        INNER JOIN resultadospreguntas AS rp ON rp.preguntaid = p.id
        WHERE
            t.cursoid = ?
            AND rp.alumnoid = ?
            AND rp.isexamen = 1
            AND rp.created_at BETWEEN ? AND ?
            AND rp.created_at = (
              SELECT MIN(rp2.created_at)
              FROM resultadospreguntas rp2
              INNER JOIN preguntas p2 ON rp2.preguntaid = p2.id
              WHERE
                  p2.evaluacionid = e.id
                  AND rp2.alumnoid = rp.alumnoid
                  AND rp2.isexamen = 1
                  AND rp2.created_at BETWEEN ? AND ?
            )
        GROUP BY t.nombre, e.nombre
    ", [$cursoid, $usuarioid, $fechainicio, $fechafin, $fechainicio, $fechafin]);

    return response()->json($resultados);
}

public function getReporteDetallado(Request $request)
{
    $cursoid = $request->input('cursoid');
    $usuarioid = $request->input('usuarioid');
    $fechainicio = $request->input('fechainicio');
    $fechafin = $request->input('fechafin');
    $tipoReporte = $request->input('tipo', 'examen'); // 'examen' o 'practica'

    $isexamen = $tipoReporte === 'examen' ? 1 : 0;

    $resultados = DB::select("
        SELECT
            u.id as usuario_id,
            u.usuario as nombre_usuario,
            a.id as alumno_id,
            a.nombre as nombre_alumno,
            a.grado,
            t.nombre AS tema,
            e.nombre AS evaluacion,
            e.id as evaluacion_id,
            p.id as pregunta_id,
            p.descripcion as pregunta,
            p.respuesta as respuesta_correcta,
            p.opcion1,
            p.opcion2,
            p.opcion3,
            p.opcion4,
            rp.respuesta as respuesta_seleccionada,
            rp.tiempo as tiempo_respuesta,
            rp.tiemporeforzamiento,
            rp.isexamen,
            rp.created_at as fecha_respuesta,
            CASE
                WHEN rp.respuesta = 'correcta' THEN 'Correcta'
                ELSE 'Incorrecta'
            END as estado_respuesta
        FROM usuarios u
        INNER JOIN alumnos a ON a.id = u.aludocenid
        INNER JOIN resultadospreguntas rp ON rp.alumnoid = a.id
        INNER JOIN preguntas p ON p.id = rp.preguntaid
        INNER JOIN evaluaciones e ON e.id = p.evaluacionid
        INNER JOIN temas t ON t.id = e.temaid
        WHERE
            t.cursoid = ?
            AND u.id = ?
            AND rp.isexamen = ?
            AND rp.created_at BETWEEN ? AND ?
        ORDER BY e.id, p.id, rp.created_at
    ", [$cursoid, $usuarioid, $isexamen, $fechainicio, $fechafin]);

    return response()->json($resultados);
}

    //
    public function store(SaveAlumnoRequest $request): JsonResponse
    {

        $alumno = Alumno::create($request->validated());

        return response()->json($alumno, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $alumno = Alumno::findOrFail($id);

        return response()->json($alumno, Response::HTTP_OK);

    }
    //
    public function update(SaveAlumnoRequest $request, string $id): JsonResponse
    {

        $alumno = Alumno::findOrFail($id);

        $alumno->update($request->validated());

        return response()->json($alumno, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $alumno = Alumno::findOrFail($id);

        $alumno->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
