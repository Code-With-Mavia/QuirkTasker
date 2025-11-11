<?php

namespace App\Http\Controllers\V2;
use App\Services\ActivityLoggerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;

use Exception;
class ActivityLoggerController extends Controller
{
    protected ActivityLoggerService $activityLoggerService;
    public function __construct(ActivityLoggerService $activityLoggerService)
    {
        $this->activityLoggerService = $activityLoggerService;
    }
    /**
     * Display a listing of the resource.
     * GET /api/logger
     * Returns all Activity Logs.
     */
    public function index()
    {
        try 
        {
            $activities = $this->activityLoggerService->showallActivityLogs();
            return response()->json(['success' => true, 'data' => $activities], 200);

        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to Activity Logs',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/logger/{id}
     * Show a single task by ID.
     */
    public function show($id)
    {
        try 
        {
            $activities = $this->activityLoggerService->findActivityLogs($id);
            if (!$activities)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Activities not found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $activities
            ], 200);

        }
        catch (Exception $e)
        {
            return response()->json([
                'success'=> false,
                'message' => 'Failed to fetch activity logs',
                'error' => $e->getMessage()
            ] , 404);
        }
    }

    /**
     * PUT /api/logger/{logs}
     * Update an existing logs by ID. Only include fields you want to change.
     */
    public function update(Request $request,$id)
    {
        try
        {
            Log::info('ActivityLog update requested', [
            'activity_logger_id' => $id,
            'user_id' => auth()->id(),
            'request_data' => $request->all(),
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);
            $validated = $request->validate([
                'user_id' => 'somtimes|integer|exists:users,id',
                'task_id' => 'sometimes|integer|exists:tasks,id',
                'action' => 'required|in:completed,not completed,in progress'
                
            ]);
            $logs = $this->activityLoggerService->updateActivityLogs($id, $validated);
            if (!$logs)
            {
                Log::warning('Update failed: Task not found', [
                'activity_logger_id' => $id,
                'user_id' => auth()->id(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found',
                ], 404);
            }
            Log::notice('ActivityLog updated successfully', [
            'activity_logger_id' => $id,
            'updated_fields' => $validated,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
            ]);
            return response()->json([
                'success' => true,
                'data' => $logs,
                'message' => 'Logs updated successfully'
            ], 200);
        }
        catch (ValidationException $ve) 
        {
            Log::error('Validation failed on update', [
                'activity_logger_id' => $id,
                'errors' => $ve->errors(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'errors' => $ve->errors()
            ], 422);
        } 
        catch (Exception $e) 
        {
            Log::error('Exception on activity log update', [
                'activity_logger_id' => $id,
                'message' => $e->getMessage(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update logs',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        try 
        {
            $result = $this->activityLoggerService->deleteActivityLogs($id);
            
            if(!$result)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Log not found or already deleted',
                ], 404);
            }
            return response()->json([
                'success'=> true,
                'message'=> 'Logs deleted successfully'
            ],200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Logs',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
