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
            return ActivityLogger::all();
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
}
?>