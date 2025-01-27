<?php

namespace App\Services;

use App\Repository\TaskRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository
    )
    {}

    public function getTasks(): Collection
    {
        return $this->taskRepository->getTasks();
    }

    public function getTask($id): object|null
    {
        return $this->taskRepository->getTask($id);
    }

    public function store(array $data)
    {
        $this->taskRepository->store($data);
    }

    public function update($id, $data)
    {
        $foundTask = $this->taskRepository->getTask($id);

        if (!$foundTask) {
            throw ValidationException::withMessages([
                'message' => 'Task not found'
            ]);
        }

        $this->taskRepository->update($id, $data);
    }
}