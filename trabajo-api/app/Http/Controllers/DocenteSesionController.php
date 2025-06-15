<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDocenteSesionRequest;
use App\Models\DocenteSesion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DocenteSesionController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $docenteSesions = DocenteSesion::latest()->get();

        return response()->json($docenteSesions, Response::HTTP_OK);

    }
    //
    public function store(SaveDocenteSesionRequest $request): JsonResponse
    {

        $docenteSesion = DocenteSesion::create($request->validated());

        return response()->json($docenteSesion, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $docenteSesion = DocenteSesion::findOrFail($id);

        return response()->json($docenteSesion, Response::HTTP_OK);

    }
    //
    public function update(SaveDocenteSesionRequest $request, string $id): JsonResponse
    {

        $docenteSesion = DocenteSesion::findOrFail($id);

        $docenteSesion->update($request->validated());

        return response()->json($docenteSesion, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $docenteSesion = DocenteSesion::findOrFail($id);

        $docenteSesion->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
