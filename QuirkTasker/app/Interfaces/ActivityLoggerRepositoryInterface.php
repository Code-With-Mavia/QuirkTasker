<?php
namespace App\Interfaces;

interface ActivityLoggerRepositoryInterface
{
    public function showallActivityLogs();

    public function log($userId, $taskId, $action, $data = null);

    public function findActivityLogs($id);

}
?>