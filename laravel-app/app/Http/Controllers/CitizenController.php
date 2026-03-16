<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Services\CitizenService;

class CitizenController extends Controller
{
    protected $citizenService;

    public function __construct(CitizenService $citizenService)
    {
        $this->citizenService = $citizenService;
    }

    public function index()
    {
        $citizens = $this->citizenService->getAll();

        return response()->json($citizens);
    }

    public function show(string $id)
    {
        $citizen = $this->citizenService->getById($id);

        return response()->json($citizen);
    }

    public function store(StoreCitizenRequest $request)
    {
        $citizen = $this->citizenService->create($request->validated());

        return response()->json([
            'message' => 'Citizen created successfully',
            'data' => $citizen
        ], 201);
    }

    public function update(UpdateCitizenRequest $request, string $id)
    {
        $citizen = $this->citizenService->update($id, $request->validated());

        return response()->json([
            'message' => 'Citizen updated successfully',
            'data' => $citizen
        ]);
    }

    public function destroy(string $id)
    {
        $this->citizenService->delete($id);

        return response()->json([
            'message' => 'Citizen deleted successfully'
        ]);
    }
}