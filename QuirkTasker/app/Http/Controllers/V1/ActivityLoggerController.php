<?php

namespace App\Http\Controllers\V1;
use App\Interfaces\Services\ActivityLoggerService;
use App\Http\Controllers\Controller;
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
     */
    /**
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
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    /**
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

    
}
