<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = auth()->user()->tasks;
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = $this->taskService->createTask([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $task = $this->taskService->updateTask($task, $request->all());
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->taskService->deleteTask($task);
        return response()->json(['message' => 'Tarea eliminada']);
    }
}
