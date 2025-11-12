<?php
namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Validation\ValidationException;
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
            return response()->json(['success' => true, 'data' => $tasks], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/tasks
     * Creates a new task. Required: title, priority, user_id.
     */
    public function store(TaskStoreRequest $request)
    {
        try 
        {
            $task = $this->taskService->createTasks($request->validated());
            return response()->json([
                'success' => true,
                'data' => $task,
                'message' => 'Task created successfully'
            ], 201);
        } 
        catch (ValidationException $ve) 
        {
            return response()->json([
                'success' => false,
                'errors' => $ve->errors()
            ], 422);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/tasks/{task}
     * Show a single task by ID.
     */
    public function show($id)
    {
        try 
        {
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
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /api/tasks/{task}
     * Update an existing task by ID. Only include fields you want to change.
     */
    public function update(TaskUpdateRequest $request, $id)
    {
        try 
        {
            $task = $this->taskService->updateTasks($id, $request->validated());
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
        } 
        catch (ValidationException $ve) 
        {
            return response()->json([
                'success' => false,
                'errors' => $ve->errors()
            ], 422);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/tasks/{task}
     * Delete a task by ID.
     */
    public function destroy($id)
    {
        try 
        {
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
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
?>