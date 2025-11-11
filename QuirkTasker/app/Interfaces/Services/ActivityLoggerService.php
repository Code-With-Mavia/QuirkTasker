<?php
namespace App\Interfaces\Services;
use App\Interfaces\ActivityLoggerRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
class ActivityLoggerService 
{
    protected ActivityLoggerRepositoryInterface $activityLoggerRepo;

    public function __construct(ActivityLoggerRepositoryInterface $activityLoggerRepo)
    {
        $this->activityLoggerRepo = $activityLoggerRepo;
    }

     public function showallActivityLogs()
    {
         try 
        {
            Log::info('Service: Fetching all Activity Logs');
            $result = $this->activityLoggerRepo->showallActivityLogs();
            Log::debug('Fetched logs count', ['count' => count($result)]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Service: Error Activity Logs', ['exception' => $e]);
            throw $e;
        }
    }

    public function findActivityLogs($id)
    {
        try 
        {
            Log::info('Service: Finding Activity Logs', ['activity_logger_id' => $id]);
            return $this->activityLoggerRepo->findActivityLogs($id);
        } 
        catch (Exception $e) 
        {
            Log::error('Service: Error finding Activity Logs', ['activity_logger_id' => $id, 'exception' => $e]);
            throw $e;
        }
    }

    public function updateActivityLogs($id, array $data)
    {
        try 
        {
            Log::info('Service: Finding Activity Logs via id to update it', ['activity_logger_id' => $id,'data' => $data]);
            return $this->activityLoggerRepo->updateActivityLogs($id, $data);
        }
        catch (Exception $e)
        {
            Log::error('Service: Error Updating Activity Logs', ['activity_logger_id' => $id,'data' => $data,'exception' => $e]);
            throw $e;
        }
    }

    public function deleteActivityLogs($id)
    {
        try
        {
            Log::info('Service: Finding Activity Logs via id to delete it', ['activity_logger_id' => $id]);
            $logs = $this->activityLoggerRepo->deleteActivityLogs($id );
            Log::debug('Deleted logs', ['id'=> $id]);
            return $logs;
        }
        catch (Exception $e)
        {
            Log::error('Service: Error deleting Activity Logs', ['activity_logger_id' => $id,'exception' => $e]);
            throw $e;
        }
    }
}
?>