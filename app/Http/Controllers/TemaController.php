<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTemaRequest;
use App\Models\Tema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;

class TemaController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $temas = Tema::latest()->get();

        return response()->json($temas, Response::HTTP_OK);

    }
    //
    public function store(SaveTemaRequest $request): JsonResponse
    {


  Log::info('Datos recibidos:', $request->all());
        $tema = Tema::create($request->validated());

        return response()->json($tema, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $tema = Tema::findOrFail($id);

        return response()->json($tema, Response::HTTP_OK);

    }

    //
    public function update(SaveTemaRequest $request, string $id): JsonResponse
    {

        $tema = Tema::findOrFail($id);

        $tema->update($request->validated());

        return response()->json($tema, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $tema = Tema::findOrFail($id);

        $tema->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }



}
