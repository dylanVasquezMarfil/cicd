<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    
    
    public function __construct(
        private readonly TaskService $taskService
    )
    {
    }

    public function index(): JsonResponse
    {
        $response = $this->taskService->getTasks();
        return response()->json([
            'message' => !$response->isEmpty() ? 'Tasks found' : 'No tasks found',
            'data' => $response
        ], !$response->isEmpty() ? 200 : 404);
    }

    public function show(int $id): JsonResponse
    {
        $response = $this->taskService->getTask($id);
        return response()->json([
            'message' => $response ? 'Task found' : 'Task not found',
            'data' => $response
        ], $response ? 200 : 404);
    }

    public function store(StoreTask $request): JsonResponse
    {
        $this->taskService->store($request->all());
        return response()->json(['message' => 'Task created successfully'], 201);
    }

    public function update(UpdateTask $request, int $id): JsonResponse
    {
        $this->taskService->update($id, $request->all());
        return response()->json(['message' => 'Task updated successfully']);
    }
}
