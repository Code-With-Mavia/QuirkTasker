<?php

namespace App\Interfaces\Repositories;
use App\Models\ActivityLogger;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ActivityLoggerRepositoryInterface;
class ActivityLoggerRepositories implements ActivityLoggerRepositoryInterface
{
    public function showallActivityLogs()
    {
        try
        {
            return ActivityLogger::latest()->paginate( 30 );
        }
        catch (Exception $e)
        {
            Log::error('Error fetching all logs', ['exception' => $e]);
            throw $e;
        }
    }

    public function findActivityLogs($id)
    {
        try 
        {
            return ActivityLogger::find($id);
        }
        catch (Exception $e)
        {
            Log::error('Error fetching tasks', ['exception' => $e]);
            throw $e;
        }
    }

    public function updateActivityLogs($id, array $data)
    {
        try 
        {
            $logs = ActivityLogger::findOrFail($id);
            $logs->update($data);
            return $logs;
        }
        catch (Exception $e)
        {
            Log::error('Error updating logs', ['exception' => $e]);
            throw $e;
        }
    }
    public function deleteActivityLogs($id)
    {
        try 
        {
            $logs = ActivityLogger::find($id);
            if($logs)
            {
                return $logs->delete();
            }
            return false;
        }
        catch (Exception $e)
        {
            Log::error('Error deleting logs', ['log_id' => $id,'exception' => $e]);
            throw $e;
        }
    }
}
?>