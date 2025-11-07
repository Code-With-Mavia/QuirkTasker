<?php
namespace App\Interfaces;

interface TaskRepositoryInterface
{
    public function showAllTasks();

    public function findTasks($id);

    public function createTasks(array $data);

    public function updateTasks($id, array $data);

    public function deleteTasks($id);
}
?>