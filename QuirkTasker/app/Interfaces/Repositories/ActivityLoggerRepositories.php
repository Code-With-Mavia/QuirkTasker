<?php

namespace App\Interfaces\Repositories;
use App\Models\ActivityLogger;
use App\Interfaces\ActivityLoggerRepositoryInterface;
class ActivityLoggerRepositories implements ActivityLoggerRepositoryInterface
{
    public function showallActivityLogs()
    {
        return ActivityLogger::latest()->paginate( 30 );
    }

    public function findActivityLogs($id)
    {
        return ActivityLogger::find($id);
    }

    public function updateActivityLogs($id, array $data)
    {   
        $logs = ActivityLogger::findOrFail($id);
        return $logs->update($data);
    }
    public function deleteActivityLogs($id)
    {
        $logs = ActivityLogger::find($id);
        if($logs)
        {
            return $logs->delete();
        }
        return false;
    }
}
?>