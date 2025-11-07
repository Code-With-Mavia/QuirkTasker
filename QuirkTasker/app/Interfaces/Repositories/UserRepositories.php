<?php

namespace App\Interfaces\Repositories;
Use Exception;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepositories implements UserRepositoryInterface
{
    public function showAllUsers()
    {
        try
        {
            return User::all();
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function findUsers($id)
    {
        try
        {
            return User::find($id);
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function createUsers(array $data)
    {
        try
        {
            return User::create($data);
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function updateusers($id, array $data)
    {
        try
        {
            $user = User::findOrFail($id);
            $user->update($data);
            return $user;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function deleteUsers($id)
    {
        try
        {
            return User::destroy($id);
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
}
?>