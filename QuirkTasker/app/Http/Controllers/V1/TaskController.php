<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Services\TaskService;
use Illuminate\Validation\ValidationException;
use Exception;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Display a listing of the tasks
    //GET api/V1/tasks/
    public function index()
    {
        try {
            $tasks = $this->taskService->showAllTasks();
            return response()->json(['success' => true, 'data' => $tasks], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Store a newly created task
    // api/v1/tasks/store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'sometimes|boolean',
                'priority' => 'required|in:High,Medium,Low',
                'due' => 'nullable|date',
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $task = $this->taskService->createTasks($validated);
            return response()->json([
                'success' => true,
                'data' => $task,
                'message' => 'Task created successfully'
            ], 201);
        } catch (ValidationException $ve) {
            return response()->json([
                'success' => false,
                'errors' => $ve->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Display a specific task
    public function show($id)
    {
        try {
            $task = $this->taskService->findTasks($id);
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $task
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update an existing task in storage
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'status' => 'sometimes|boolean',
                'priority' => 'sometimes|in:High,Medium,Low',
                'due' => 'nullable|date',
                'user_id' => 'sometimes|integer|exists:users,id'
            ]);
            $task = $this->taskService->updateTasks($id, $validated);
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $task,
                'message' => 'Task updated successfully'
            ], 200);
        } catch (ValidationException $ve) {
            return response()->json([
                'success' => false,
                'errors' => $ve->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Remove a task from storage
    public function destroy($id)
    {
        try {
            $result = $this->taskService->deleteTasks($id);
            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found or already deleted',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
?>