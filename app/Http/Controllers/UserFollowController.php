<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\UserFollow;
use Illuminate\Http\Request;

class UserFollowController extends GeneralController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $getUserFollowing = $user->following()->get()->map(function ($item) {
                return new UserResource($item->follow);
            });
            $getUserFollower = $user->follower()->get()->map(function ($item) {
                return new UserResource($item->user);
            });
            $this->redis->set('user:data:follower:'.$user->id, json_encode(
                $getUserFollower
            ));
            $this->redis->set('user:data:following:'.$user->id, json_encode(
                $getUserFollowing
            ));
            $userFollower = $this->redis->get('user:data:follower:'.$user->id);
            $userFollowing = $this->redis->get('user:data:following:'.$user->id);

            return $this->renderInertia('User/Follow', [
                'following' => json_decode($userFollowing),
                'follower' => json_decode($userFollower),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserFollow $userFollow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserFollow $userFollow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserFollow $userFollow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFollow $userFollow)
    {
        //
    }
}
