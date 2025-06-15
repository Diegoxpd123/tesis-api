<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveResultadoPreguntaRequest;
use App\Models\ResultadoPregunta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ResultadoPreguntaController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $resultadoPreguntas = ResultadoPregunta::latest()->get();

        return response()->json($resultadoPreguntas, Response::HTTP_OK);

    }
    //
    public function store(SaveResultadoPreguntaRequest $request): JsonResponse
    {
  Log::info('Datos recibidos:', $request->all());
        $resultadoPregunta = ResultadoPregunta::create($request->validated());

        return response()->json($resultadoPregunta, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $resultadoPregunta = ResultadoPregunta::findOrFail($id);

        return response()->json($resultadoPregunta, Response::HTTP_OK);

    }
    //
    public function update(SaveResultadoPreguntaRequest $request, string $id): JsonResponse
    {

        $resultadoPregunta = ResultadoPregunta::findOrFail($id);

        $resultadoPregunta->update($request->validated());

        return response()->json($resultadoPregunta, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $resultadoPregunta = ResultadoPregunta::findOrFail($id);

        $resultadoPregunta->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
