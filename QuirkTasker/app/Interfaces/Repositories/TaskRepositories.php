<?php
namespace App\Interfaces\Repositories;
use App\Models\Tasks;
use App\Interfaces\TaskRepositoryInterface;
use Exception;

class TaskRepositories implements TaskRepositoryInterface
{
    public function showAllTasks()
    {
        try
        {
            return Tasks::all();
        }
        catch (Exception $e)
        {
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
            throw $e;
        }
    }

    public function updateTasks($id, array $data)
    {
        try 
        {
            return Tasks::update($id, $data);
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function deleteTasks($id)
    {
        try 
        {
            return Tasks::destroy($id);
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }
}

?>