<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveInstitucionRequest;
use App\Models\Institucion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class InstitucionController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $institucions = Institucion::latest()->get();

        return response()->json($institucions, Response::HTTP_OK);

    }
    //
    public function store(SaveInstitucionRequest $request): JsonResponse
    {

        $institucion = Institucion::create($request->validated());

        return response()->json($institucion, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $institucion = Institucion::findOrFail($id);

        return response()->json($institucion, Response::HTTP_OK);

    }
    //
    public function update(SaveInstitucionRequest $request, string $id): JsonResponse
    {

        $institucion = Institucion::findOrFail($id);

        $institucion->update($request->validated());

        return response()->json($institucion, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $institucion = Institucion::findOrFail($id);

        $institucion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
