<?php
namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class TaskService
{
    protected TaskRepositoryInterface $taskRepo;

    public function __construct(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function showAllTasks()
    {
        try 
        {
            Log::info('Service: Fetching all tasks');
            $result = $this->taskRepo->showAllTasks();
            Log::debug('Fetched tasks count', ['count' => count($result)]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Service: Error fetching tasks', ['exception' => $e]);
            throw $e;
        }
    }

    public function findTasks($id)
    {
        try 
        {
            Log::info('Service: Finding task', ['task_id' => $id]);
            return $this->taskRepo->findTasks($id);
        } catch (Exception $e) 
        {
            Log::error('Service: Error finding task', ['task_id' => $id, 'exception' => $e]);
            throw $e;
        }
    }

    public function createTasks(array $data)
    {
        try 
        {
            Log::info('Service: Creating task', ['data' => $data]);
            return $this->taskRepo->createTasks($data);
        } 
        catch (Exception $e) 
        {
            Log::error('Service: Error creating task', ['data' => $data, 'exception' => $e]);
            throw $e;
        }
    }

    public function updateTasks($id, array $data)
    {
        try 
        {
            Log::info('Service: Updating task', ['task_id' => $id, 'data' => $data]);
            return $this->taskRepo->updateTasks($id, $data);
        } 
        catch (Exception $e) 
        {
            Log::error('Service: Error updating task', ['task_id' => $id, 'data' => $data, 'exception' => $e]);
            throw $e;
        }
    }

    public function deleteTasks($id)
    {
        try 
        {
            Log::info('Service: Deleting task', ['task_id' => $id]);
            return $this->taskRepo->deleteTasks($id);
        } 
        catch (Exception $e) 
        {
            Log::error('Service: Error deleting task', ['task_id' => $id, 'exception' => $e]);
            throw $e;
        }
    }
}
