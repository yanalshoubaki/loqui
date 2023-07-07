<?php


namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserFollowerRepositoryInterface
{

    /**
     * Get all follower users
     *
     * @param integer $id
     *
     * @return Collection
     */
    public function getAllFollowerUsers(int $id): Collection;


    /**
     * Add user to follower list
     *
     * @param integer $userId
     * @param integer $followId
     *
     * @return bool
     */
    public function addFollowerUser(int $userId, int $followId): bool;

    /**
     * Remove user from follower list
     *
     * @param integer $userId
     * @param integer $followId
     * @return bool
     */
    public function removeFollowerUser(int $userId, int $followId): bool;
}
