<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEvaluacionRequest;
use App\Models\Evaluacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EvaluacionController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $evaluacions = Evaluacion::latest()->get();

        return response()->json($evaluacions, Response::HTTP_OK);

    }
    //
    public function store(SaveEvaluacionRequest $request): JsonResponse
    {

        $evaluacion = Evaluacion::create($request->validated());

        return response()->json($evaluacion, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $evaluacion = Evaluacion::findOrFail($id);

        return response()->json($evaluacion, Response::HTTP_OK);

    }
    //
    public function update(SaveEvaluacionRequest $request, string $id): JsonResponse
    {

        $evaluacion = Evaluacion::findOrFail($id);

        $evaluacion->update($request->validated());

        return response()->json($evaluacion, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $evaluacion = Evaluacion::findOrFail($id);

        $evaluacion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
