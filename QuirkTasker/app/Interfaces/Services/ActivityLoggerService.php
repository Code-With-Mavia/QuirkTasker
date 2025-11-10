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
            
            return $this->activityLoggerRepo->showallActivityLogs();
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
        } catch (Exception $e) 
        {
            Log::error('Service: Error finding Activity Logs', ['activity_logger_id' => $id, 'exception' => $e]);
            throw $e;
        }
    }
}
?>