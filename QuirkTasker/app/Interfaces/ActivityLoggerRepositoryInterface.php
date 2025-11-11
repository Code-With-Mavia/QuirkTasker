<?php
namespace App\Interfaces;

interface ActivityLoggerRepositoryInterface
{
    public function showallActivityLogs();
    public function findActivityLogs($id);
    public function updateActivityLogs($id, array $data);
    public function deleteActivityLogs($id);
}
?>