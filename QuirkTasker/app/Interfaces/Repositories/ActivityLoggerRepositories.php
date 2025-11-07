<?php

namespace App\Interfaces\Repositories;
use App\Models\ActivityLogger;
use Exception;
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
            throw $e;
        }
    }

    public function log($userId, $taskId, $action, $data = null)
    {
        try
        {
            return ActivityLogger::log($userId, $taskId, $action, $data);
        }
        catch (Exception $e)
        {
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
            throw $e;
        }
    }
}
?>