<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get All Users
     */
    public function getAllUsers(): Collection;

    /**
     * Get User By Id
     */
    public function getUserById(int $id): User;

    /**
     * Crate User
     */
    public function createUser(array $data): User;

    /**
     * Update User
     */
    public function updateUser(int $id, array $data): User;

    /**
     * Delete User
     *
     * @return void
     */
    public function deleteUser(int $id);
}
