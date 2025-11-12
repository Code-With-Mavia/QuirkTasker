<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Services\ActivityLoggerService;
use App\Http\Requests\LoggerUpdateRequest;
use App\Http\Resources\ActivityLoggerResource;
use Exception;

class ActivityLoggerController extends Controller
{
    protected ActivityLoggerService $activityLoggerService;

    public function __construct(ActivityLoggerService $activityLoggerService)
    {
        $this->activityLoggerService = $activityLoggerService;
    }

    /**
     * GET /api/logger
     * Returns all activity logs.
     */
    public function index()
    {
        try {
            $activities = $this->activityLoggerService->showAllActivityLogs();
            return ActivityLoggerResource::collection($activities)->additional(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch activity logs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/logger/{id}
     * Show a single log.
     */
    public function show($id)
    {
        try {
            $activity = $this->activityLoggerService->findActivityLogs($id);

            if (!$activity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Activity log not found',
                ], 404);
            }

            return (new ActivityLoggerResource($activity))
                ->additional(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch activity log',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * PUT /api/logger/{id}
     * Update an activity log.
     */
    public function update(LoggerUpdateRequest $request, $id)
    {
        try {
            $log = $this->activityLoggerService->updateActivityLogs($id, $request->validated());

            if (!$log) {
                return response()->json([
                    'success' => false,
                    'message' => 'Activity log not found',
                ], 404);
            }

            return (new ActivityLoggerResource($log))
                ->additional(['success' => true, 'message' => 'Activity log updated successfully']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update activity log',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DELETE /api/logger/{id}
     * Delete an activity log.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->activityLoggerService->deleteActivityLogs($id);

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Activity log not found or already deleted',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Activity log deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete activity log',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
?>