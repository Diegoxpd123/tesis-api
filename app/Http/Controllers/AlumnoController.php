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
