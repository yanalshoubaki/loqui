<?php


namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface {

    /**
     * Get All Users
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Get User By Id
     *
     * @param integer $id
     * @return User
     */
    public function getUserById(int $id): User;

    /**
     * Crate User
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Update User
     *
     * @param integer $id
     * @param array $data
     * @return User
     */
    public function updateUser(int $id, array $data): User;

    /**
     * Delete User
     *
     * @param integer $id
     * @return void
     */
    public function deleteUser(int $id);
}
