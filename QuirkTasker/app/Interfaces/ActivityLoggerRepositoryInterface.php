<?php
namespace App\Interfaces;

interface ActivityLoggerRepositoryInterface
{
    public function showallActivityLogs();
    public function findActivityLogs($id);

}
?>