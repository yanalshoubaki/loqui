<?php


namespace App\Repositories;


use App\Interfaces\UserFollowerRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Database\Eloquent\Collection;

class UserFollowerRepository implements UserFollowerRepositoryInterface
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
    public function getAllFollowerUsers(int $id): Collection
    {
        $user = $this->userRepository->getUserById($id);
        $userFollowerList = $user->follower;
        return $userFollowerList;
    }

    /**
     * Add user to follower list
     *
     * @param integer $userId
     * @param integer $followId
     *
     * @return bool
     */
    public function addFollowerUser(int $userId, int $followId): bool
    {
        try {
            $user = $this->userRepository->getUserById($userId);
            $userFollowersList = $user->follower();
            $userFollower = new UserFollower([
                'follow_id' => $userId,
                'user_id' => $followId
            ]);
            $userFollowersList->save($userFollower);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     * Remove user from follower list
     *
     * @param integer $userId
     * @param integer $followId
     *
     * @return bool
     */
    public function removeFollowerUser(int $userId, int $followId): bool
    {
        try {
            $user = $this->userRepository->getUserById($userId);
            $userFollowerList = $user->follower;
            $userFollowerList->where('user_id', $followId)->where('follow_id', $userId)->first()->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
