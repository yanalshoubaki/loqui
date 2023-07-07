<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\User\Followers\AddUserToFollowersList;
use App\Http\Requests\API\User\Followers\RemoveUserFromFollowersList;
use App\Http\Requests\API\User\Following\AddUserToFollowingList;
use App\Http\Requests\API\User\Following\RemoveUserFromFollowingList;
use App\Http\Resources\UserResource;
use App\Interfaces\UserFollowerRepositoryInterface;
use App\Interfaces\UserFollowingRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserFollower;
use App\Models\UserFollowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Handler
{
    private UserRepositoryInterface $userRepository;

    private UserFollowingRepositoryInterface $userFollowingRepository;

    private UserFollowerRepositoryInterface $userFollowerRepository;

    public function __construct(UserRepositoryInterface $userRepository, UserFollowingRepositoryInterface $userFollowingRepository, UserFollowerRepositoryInterface $userFollowerRepository)
    {
        $this->userRepository = $userRepository;
        $this->userFollowingRepository = $userFollowingRepository;
        $this->userFollowerRepository = $userFollowerRepository;
    }

    /**
     *  Get My Profile
     */
    public function getMyProfile(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $user = $this->userRepository->getUserById($currentUser->id);

        return $this->responseSuccess(new UserResource($user));
    }

    /**
     * Get following list for authenticated user
     */
    public function getFollowingList(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $userFollowingList = $this->userFollowingRepository->getAllFollowingUsers($currentUser->id);
        $users = $userFollowingList->map(function (UserFollowing $user) {
            $userFollow = $this->userRepository->getUserById($user->follow_id);

            return new UserResource($userFollow);
        });

        return $this->responseSuccess(UserResource::collection($users));
    }

    /**
     * Add user to following list
     *
     * @param  Request  $request
     */
    public function addUserToFollowingList(AddUserToFollowingList $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $this->userFollowingRepository->addFollowingUser($currentUser->id, $request->follow_id);

            return $this->responseSuccess(null, 201);
        } catch (\Throwable $th) {
            return $this->responseError('Error'.$th->getMessage(), 500);
        }
    }

    /**
     * Remove user to following list
     *
     * @param  Request  $request
     */
    public function removeUserFromFollowingList(RemoveUserFromFollowingList $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $this->userFollowingRepository->removeFollowingUser($currentUser->id, $request->follow_id);

            return $this->responseSuccess(null, 204);
        } catch (\Throwable $th) {
            return $this->responseError('Error'.$th->getMessage(), 500);
        }
    }

    /**
     * Get user followers list
     */
    public function getFollowersList(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $userFollowersList = $this->userFollowerRepository->getAllFollowerUsers($currentUser->id);
        $users = $userFollowersList->map(function (UserFollower $user) {
            $userFollow = $this->userRepository->getUserById($user->user_id);

            return new UserResource($userFollow);
        });

        return $this->responseSuccess(UserResource::collection($users));
    }

    public function addUserToFollowersList(AddUserToFollowersList $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $this->userFollowerRepository->addFollowerUser($currentUser->id, $request->follow_id);

            return $this->responseSuccess(null, 201);
        } catch (\Throwable $th) {
            return $this->responseError('Error'.$th->getMessage(), 500);
        }
    }

    public function removeUserFromFollowersList(RemoveUserFromFollowersList $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $this->userFollowerRepository->removeFollowerUser($currentUser->id, $request->follow_id);

            return $this->responseSuccess(null, 204);
        } catch (\Throwable $th) {
            return $this->responseError('Error'.$th->getMessage(), 500);
        }
    }
}
