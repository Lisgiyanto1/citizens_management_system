<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Services\CitizenService;
use Illuminate\Http\JsonResponse;

class CitizenController extends Controller
{
    protected $citizenService;

    public function __construct(CitizenService $citizenService)
    {
        $this->citizenService = $citizenService;
    }

    public function index(): JsonResponse
    {
        $citizens = $this->citizenService->getAll();

        return response()->json($citizens);
    }

    public function show(string $id): JsonResponse
    {
        $citizen = $this->citizenService->getById($id);

        return response()->json($citizen);
    }

    public function store(StoreCitizenRequest $request): JsonResponse
    {
        $citizen = $this->citizenService->create($request->validated());

        return response()->json([
            'message' => 'Citizen created successfully',
            'data' => $citizen
        ], 201);
    }

    public function update(UpdateCitizenRequest $request, string $id): JsonResponse
    {
        $citizen = $this->citizenService->update($id, $request->validated());

        return response()->json([
            'message' => 'Citizen updated successfully',
            'data' => $citizen
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden. Only admin can perform this action.'
            ], 403);
        }

        $this->citizenService->delete($id);

        return response()->json([
            'message' => 'Citizen deleted successfully'
        ]);
    }
}