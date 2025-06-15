<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDocenteRequest;
use App\Models\Docente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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



}
