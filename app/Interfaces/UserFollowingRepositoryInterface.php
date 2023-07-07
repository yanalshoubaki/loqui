<?php


namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserFollowingRepositoryInterface {

    /**
     * Get all following users
     *
     * @param integer $id
     *
     * @return Collection
     */
    public function getAllFollowingUsers(int $id): Collection;


    /**
     * Add user to following list
     *
     * @param integer $userId
     * @param integer $followId
     *
     * @return bool
     */
    public function addFollowingUser(int $userId, int $followId): bool;

    /**
     * Remove user from following list
     *
     * @param integer $userId
     * @param integer $followId
     * @return bool
     */
    public function removeFollowingUser(int $userId, int $followId): bool;
}
