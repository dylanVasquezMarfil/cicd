<?php

namespace App\Repository;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaskRepository
{

    public function getTasks(): Collection
    {
        return DB::table('tasks')
        ->select('id', 'name', 'description')
        ->selectRaw('IF(completed, "Completed", "Not Completed") as status')
        ->where('is_active', true)
        ->get();
    }

    public function getTask($id): object|null
    {
        return DB::table('tasks')
        ->select('id', 'name', 'description')
        ->selectRaw('IF(completed, "Completed", "Not Completed") as status')
        ->where('id', $id)
        ->where('is_active', true)
        ->first();
    }

    public function store(array $data): void
    {
        Task::create($data);
    }

    public function update($id, $data): void
    {
        Task::where('id', $id)->first()->update($data);
    }
}