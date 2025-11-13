<?php
namespace App\Interfaces\Repositories;

use App\Models\Tasks;
use App\Interfaces\TaskRepositoryInterface;


class TaskRepositories implements TaskRepositoryInterface
{
    public function showAllTasks()
    {
        return Tasks::select('id','title','status','priority','due','user_id')->paginate(30);
    }

    public function findTasks($id)
    {
        return Tasks::find($id);
    }

    public function createTasks(array $data)
    {
        return Tasks::create($data);
    }

    public function updateTasks($id, array $data)
    {
        $task = Tasks::findOrFail($id);
        return $task->update($data);
    }

    public function deleteTasks($id)
    {
        $task = Tasks::find($id);
        if ($task) 
        {
            $task->delete();
            return true;
        }
        return false;
    }

}
