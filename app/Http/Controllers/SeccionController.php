<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSeccionRequest;
use App\Models\Seccion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SeccionController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $seccions = Seccion::latest()->get();

        return response()->json($seccions, Response::HTTP_OK);

    }
    //
    public function store(SaveSeccionRequest $request): JsonResponse
    {

        $seccion = Seccion::create($request->validated());

        return response()->json($seccion, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $seccion = Seccion::findOrFail($id);

        return response()->json($seccion, Response::HTTP_OK);

    }
    //
    public function update(SaveSeccionRequest $request, string $id): JsonResponse
    {

        $seccion = Seccion::findOrFail($id);

        $seccion->update($request->validated());

        return response()->json($seccion, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $seccion = Seccion::findOrFail($id);

        $seccion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
