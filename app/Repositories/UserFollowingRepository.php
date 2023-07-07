<?php


namespace App\Repositories;


use App\Interfaces\UserFollowingRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\UserFollowing;

class UserFollowingRepository implements UserFollowingRepositoryInterface
{


    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all follower users
     *
     * @return Collection
     */
    public function getAllFollowingUsers(int $id): Collection
    {
        $user = $this->userRepository->getUserById($id);
        $userFollowerList = $user->following;
        return $userFollowerList;
    }

    /**
     * Add user to following list
     *
     * @param integer $userId
     * @param integer $followId
     * @return bool
     */
    public function addFollowingUser(int $userId, int $followId): bool
    {
        try {
            $user = $this->userRepository->getUserById($userId);
            $userFollowerList = $user->following();
            $userFollowing = new UserFollowing([
                'user_id' => $userId,
                'follow_id' => $followId
            ]);
            $userFollowerList->save($userFollowing);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     * Remove user from following list
     *
     * @param integer $userId
     * @param integer $followId
     * @return bool
     */
    public function removeFollowingUser(int $userId, int $followId): bool
    {
        try {
            $user = $this->userRepository->getUserById($userId);
            $userFollowerList = $user->following;
            $userFollowerList->where('user_id', $userId)->where('follow_id', $followId)->first()->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
