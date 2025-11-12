<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class UserService
{
    protected UserRepositoryInterface $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    // Fetch all users
    public function showAllUsers()
    {
        try {
            Log::info('Fetching all users');
            $result = $this->users->showAllUsers();
            Log::debug('Fetched users count', ['count' => count($result)]);
            return $result;
        } catch (Exception $e) {
            Log::error('Failed to fetch all users', ['exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Find single user by ID
    public function findUsers($id)
    {
        try {
            Log::info('Fetching user', ['user_id' => $id]);
            $user = $this->users->findUsers($id);

            if (!$user) {
                Log::warning('User not found', ['user_id' => $id]);
                return null;
            }

            Log::debug('User fetched successfully', ['user_id' => $id]);
            return $user;
        } catch (Exception $e) {
            Log::error('Error fetching user', ['user_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Create new user
    public function createUsers(array $data)
    {
        try {
            Log::info('Creating new user', ['data' => $data]);
            $user = $this->users->createUsers($data);

            Log::debug('User created successfully', ['user_id' => $user->id]);
            return $user;
        } catch (Exception $e) {
            Log::error('Error creating user', ['data' => $data, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Update user
    public function updateUsers($id, array $data)
    {
        try {
            Log::info('Updating user', ['user_id' => $id, 'data' => $data]);
            $updated = $this->users->updateUsers($id, $data);

            if (!$updated) {
                Log::warning('Update failed - user not found', ['user_id' => $id]);
                return null;
            }

            Log::debug('User updated successfully', ['user_id' => $id]);
            return $updated;
        } catch (Exception $e) {
            Log::error('Error updating user', ['user_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }

    // Delete user
    public function deleteUsers($id)
    {
        try {
            Log::info('Deleting user', ['user_id' => $id]);
            $deleted = $this->users->deleteUsers($id);

            if (!$deleted) {
                Log::warning('User not found or already deleted', ['user_id' => $id]);
                return false;
            }

            Log::debug('User deleted successfully', ['user_id' => $id]);
            return true;
        } catch (Exception $e) {
            Log::error('Error deleting user', ['user_id' => $id, 'exception' => $e->getMessage()]);
            throw $e;
        }
    }
}

?>