<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UpdateUserMetaRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends ApiHandler
{
    /**
     * Get user authenticated data
     *
     * @param Request $request
     * @return JsonResource
     */
    public function me(Request $request): JsonResponse
    {

        return $this->getResponse($request->user(), "user data", "success");
    }

    /**
     * Update user data
     *
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function updateUserRequest(UpdateUserRequest $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user->hasDirectPermission('update user');
            $inputs = $request->getInput();
            $user->update($inputs);
            return $this->getResponse($user, "user data updated", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Get user data by username
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getUserByUsername(User $user): JsonResponse
    {
        try {
            return $this->getResponse($user, "user data", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Deactivate user account
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deactivateAccountRequest(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user->hasDirectPermission('update user');
            $user->status = -1;
            $user->save();
            return $this->getResponse($user, "user deactivated", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Delete user account
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAccountRequest(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user->hasDirectPermission('delete user');
            $user->status = -2;
            $user->save();
            return $this->getResponse($user, "user deleted", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Update user meta
     *
     * @param UpdateUserMetaRequest $request
     * @return JsonResponse
     */
    public function updateUserMeta(UpdateUserMetaRequest $request): JsonResponse
    {
        try {
            $inputs = $request->getInputs();
            /** @var \App\Models\User $user */
            $user = $request->user();

$user->hasDirectPermission('update user');
            $user->meta()->updateOrCreate(
                ['meta_key' => $inputs['meta_key']],
                ['meta_value' => $inputs['meta_value']]
            );
            return $this->getResponse($user->meta()->get([
                'meta_key', 'meta_value'
            ]), 'User meta updated', "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Get user followers
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getUserFollowing(User $user): JsonResponse
    {
        try {
            return $this->getResponse($user->following, "user following", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Get user followers
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getUserFollowers(User $user): JsonResponse
    {
        try {
            return $this->getResponse($user->follower, "user followers", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Follow user
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function followUser(Request $request, User $user): JsonResponse
    {
        try {
            if ($user->id === $request->user()->id) {
                return $this->getResponse(null, "You can't make this actions", "error");
            }
            if ($user->following()->where('follow_id', $request->user()->id)->exists()) {
                return $this->getResponse(null, "You already follow this user", "error");
            }
            $user->following()->create([
                'follow_id' => $request->user()->id,
            ]);
            return $this->getResponse($request->user()->following, "User follow ", "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Unfollow user
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function unfollowUser(Request $request, User $user): JsonResponse
    {
        try {
            if ($user->id === $request->user()->id) {
                return $this->getResponse(null, "You can't make this actions", "error");
            }
            if (!$user->following()->where('follow_id', $request->user()->id)->exists()) {
                return $this->getResponse(null, "You are't following this user", "error");
            }

            $user->following()->where('follow_id', $request->user()->id)->delete();
            return $this->getResponse($user, 'User unfollowed', "success");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }
}
