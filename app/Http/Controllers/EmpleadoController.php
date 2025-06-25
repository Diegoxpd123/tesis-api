<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEmpleadoRequest;
use App\Models\Empleado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmpleadoController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $empleados = Empleado::latest()->get();

        return response()->json($empleados, Response::HTTP_OK);

    }
    //
    public function store(SaveEmpleadoRequest $request): JsonResponse
    {


        $empleado = Empleado::create($request->validated());

        return response()->json($empleado, Response::HTTP_CREATED);

    }
    //
    public function show(string $id): JsonResponse
    {
        $empleado = Empleado::findOrFail($id);

        return response()->json($empleado, Response::HTTP_OK);

    }
    //
    public function update(SaveEmpleadoRequest $request, string $id): JsonResponse
    {

        $empleado = Empleado::findOrFail($id);

        $empleado->update($request->validated());

        return response()->json($empleado, Response::HTTP_OK);

    }
     //
    public function destroy(string $id): JsonResponse
    {

        $empleado = Empleado::findOrFail($id);

        $empleado->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }

}
