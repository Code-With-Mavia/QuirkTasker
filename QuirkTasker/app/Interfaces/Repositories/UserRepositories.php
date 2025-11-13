<?php

namespace App\Interfaces\Repositories;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepositories implements UserRepositoryInterface
{
    public function showAllUsers()
    {
        return User::withCount('tasks')->paginate(50);
    }

    public function findUsers($id)
    {
        return User::findOrFail($id);
    }

    public function createUsers(array $data)
    {
        return User::create($data);
    }

    public function updateUsers($id, array $data)
    {
        $user = User::findOrFail($id);
        return $user->update($data);       
    }

    public function deleteUsers($id)
    {
        return User::destroy($id);  
    }
}
?>