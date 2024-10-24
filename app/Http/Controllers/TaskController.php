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
        //dd($task);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        // Asegurarse de que el usuario autenticado es el dueño de la tarea
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'No tienes permiso para actualizar esta tarea.'], 403);
        }
    
        $task = $this->taskService->updateTask($task, $validated);
        return response()->json($task);
    }
    

    public function destroy(Task $task)
    {
        $this->taskService->deleteTask($task);
        return response()->json(['message' => 'Tarea eliminada']);
    }
}
