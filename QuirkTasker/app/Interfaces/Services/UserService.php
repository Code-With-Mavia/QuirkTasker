<?php
namespace App\Interfaces\Services;

use Illuminate\Support\Facades\Log;
use App\Interfaces\Repositories\UserRepositories;
use Exception;

class UserService
{
    protected UserRepositories $users;
    public function __construct(UserRepositories $users)
    {
        $this->users = $users;
    }

    // Show all users
    public function showAllUsers()
    {
        try 
        {
            Log::info('Fetching all users');
            $result = $this->users->showAllUsers();
            Log::debug('Fetched users count', ['count' => count($result)]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to fetch all users', ['exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Find single user
    public function findUsers($id)
    {
        try 
        {
            Log::info('Finding user', ['user_id' => $id]);
            $result = $this->users->findUsers($id);
            Log::debug('User fetched', ['data' => $result]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to find user', ['user_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Create new user
    public function createUsers(array $data)
    {
        try 
        {
            Log::info('Creating user', ['data' => $data]);
            $result = $this->users->createUsers($data);
            Log::notice('User created', ['result' => $result]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to create user', ['data' => $data, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Update user
    public function updateUsers($id, array $data)
    {
        try 
        {
            Log::info('Updating user', ['user_id' => $id, 'data' => $data]);
            $result = $this->users->updateUsers($id, $data);
            Log::notice('User updated', ['user_id' => $id, 'result' => $result]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to update user', ['user_id' => $id, 'data' => $data, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Delete user
    public function deleteUsers($id)
    {
        try 
        {
            Log::info('Deleting user', ['user_id' => $id]);
            $result = $this->users->deleteUsers($id);
            Log::notice('User deleted', ['user_id' => $id, 'result' => $result]);
            return $result;
        } 
        catch (Exception $e) 
        {
            Log::error('Failed to delete user', ['user_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }
}
?>