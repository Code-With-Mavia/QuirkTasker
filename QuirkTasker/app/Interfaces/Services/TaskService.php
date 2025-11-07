<?php
namespace App\Interfaces\Services;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Interfaces\TaskRepositoryInterface;

class TaskService
{
    protected TaskRepositoryInterface $task;
    public function __construct(TaskRepositoryInterface $task)
    {
        $this->task = $task;
    }

    public function showAllTasks()
    {
        try
        {
            Log::info("Fetching all tasks");
            $result = $this->task->showAllTasks();
            Log::debug('Fetched tasks count', ['count' => count($result)]);
            return $result;
        }
        catch(Exception $e)
        {
            Log::error($e->getMessage());
        }

    }

    public function findTasks($id)
    {
        try 
        {
            Log::info('Finding tasks',['tasks_id' => $id]);
            $result = $this->task->findTasks($id);
            Log::debug('Task Fetched ', ['data'=> $result]);
            return $result;
        }
        catch(Exception $e)
        {
            Log::error('Failed to find user', ['tasks_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }
    
    public function createTasks(array $data)
    {
        try 
        {
            Log::info('Creating task', ['data' => $data]);
            $result = $this->task->createTasks($data);
            Log::notice('Task created', ['result' => $result]);
            return $result;
        }
        catch(Exception $e)
        {
            Log::error('Failed to create task', ['data' => $data, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }
    public function updateTasks($id,array $data)
    {
        try 
        {
            Log::info('Updating task', ['tasks_id' => $id, 'data' => $data]);
            $result = $this->task->updateTasks($id, $data);
            Log::notice('Task updated', ['tasks_id' => $id, 'result' => $result]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to update task', ['tasks_id' => $id, 'data' => $data, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    public function deleteTasks($id)
    {
         try 
        {
            Log::info('Deleting task', ['tasks_id' => $id]);
            $result = $this->task->deleteTasks($id);
            Log::notice('User deleted', ['tasks_id' => $id, 'result' => $result]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to delete user', ['tasks_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }
}

?>