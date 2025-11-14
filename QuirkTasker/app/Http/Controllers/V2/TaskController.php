<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Exception;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * GET /api/tasks
     * Returns all tasks.
     */
    public function index()
    {
        try
        {
            $tasks = $this->taskService->showAllTasks();
            return TaskResource::collection($tasks)->additional(['success' => true]);
        }
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/tasks
     * Creates a new task.
     */
    public function store(TaskStoreRequest $request)
    {
        try
        {
            $task = $this->taskService->createTasks($request->validated());
            return (new TaskResource($task))->additional(['success' => true, 'message' => 'Task created successfully']);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/tasks/{id}
     * Show a single task.
     */
    public function show($id)
    {
        try
        {
            $task = $this->taskService->findTasks($id);

            if (!$task)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found',
                ], 404);
            }

            return (new TaskResource($task))->additional(['success' => true]);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch task',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * PUT /api/tasks/{id}
     * Update a task.
     */
    public function update(TaskUpdateRequest $request, $id)
    {
        try
        {
            $task = $this->taskService->updateTasks($id, $request->validated());

            if (!$task)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found',
                ], 404);
            }

            return (new TaskResource($task))->additional(['success' => true, 'message' => 'Task updated successfully']);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * DELETE /api/tasks/{id}
     * Delete a task.
     */
    public function destroy($id)
    {
        try
        {
            $deleted = $this->taskService->deleteTasks($id);
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found or already deleted',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully',
            ], 200);

        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

}
?>
