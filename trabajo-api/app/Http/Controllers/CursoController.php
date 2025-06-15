<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCursoRequest;
use App\Models\Curso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CursoController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $cursos = Curso::latest()->get();

        return response()->json($cursos, Response::HTTP_OK);

    }
    //
    public function store(SaveCursoRequest $request): JsonResponse
    {

        $curso = Curso::create($request->validated());

        return response()->json($curso, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $curso = Curso::findOrFail($id);

        return response()->json($curso, Response::HTTP_OK);

    }
    //
    public function update(SaveCursoRequest $request, string $id): JsonResponse
    {

        $curso = Curso::findOrFail($id);

        $curso->update($request->validated());

        return response()->json($curso, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $curso = Curso::findOrFail($id);

        $curso->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
