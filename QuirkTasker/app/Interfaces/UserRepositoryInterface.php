<?php
namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function showAllUsers();

    public function findUsers($id);

    public function createUsers(array $data);

    public function updateusers($id, array $data);

    public function deleteUsers($id);
}
?>