<?php
namespace App\Interfaces\Repositories;

use App\Models\Tasks;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class TaskRepositories implements TaskRepositoryInterface
{
    public function showAllTasks()
    {
        try 
        {
            return Tasks::select('id','title','status','priority','due','user_id')->paginate(50);
        } 
        catch (Exception $e) 
        {
            Log::error('Error fetching all tasks', ['exception' => $e]);
            throw $e;
        }
    }

    public function findTasks($id)
    {
        try 
        {
            return Tasks::find($id);
        } 
        catch (Exception $e) 
        {
            Log::error('Error finding task', ['task_id' => $id, 'exception' => $e]);
            throw $e;
        }
    }

    public function createTasks(array $data)
    {
        try 
        {
            return Tasks::create($data);
        } 
        catch (Exception $e) 
        {
            Log::error('Error creating task', ['data' => $data, 'exception' => $e]);
            throw $e;
        }
    }

    public function updateTasks($id, array $data)
    {
        try 
        {
            $task = Tasks::findOrFail($id);
            $task->update($data);
            return $task;
        } 
        catch (Exception $e) 
        {
            Log::error('Error updating task', ['task_id' => $id, 'data' => $data, 'exception' => $e]);
            throw $e;
        }
    }

    public function deleteTasks($id)
    {
        try 
        {
            $task = Tasks::find($id);
            if ($task) 
            {
                return $task->delete();
            }
            return false;
        } 
        catch (Exception $e) 
        {
            Log::error('Error deleting task', ['task_id' => $id, 'exception' => $e]);
            throw $e;
        }
    }
}
