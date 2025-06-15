<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePreguntaRequest;
use App\Models\Pregunta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PreguntaController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $preguntas = Pregunta::latest()->get();

        return response()->json($preguntas, Response::HTTP_OK);

    }
    //
    public function store(SavePreguntaRequest $request): JsonResponse
    {

        $pregunta = Pregunta::create($request->validated());

        return response()->json($pregunta, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $pregunta = Pregunta::findOrFail($id);

        return response()->json($pregunta, Response::HTTP_OK);

    }
    //
    public function update(SavePreguntaRequest $request, string $id): JsonResponse
    {

        $pregunta = Pregunta::findOrFail($id);

        $pregunta->update($request->validated());

        return response()->json($pregunta, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $pregunta = Pregunta::findOrFail($id);

        $pregunta->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
