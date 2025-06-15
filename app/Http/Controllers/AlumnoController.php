<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AlumnoController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $alumnos = Alumno::latest()->get();

        return response()->json($alumnos, Response::HTTP_OK);

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
