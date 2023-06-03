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

            return $this->renderInertia('User/Follow', [
                'following' => $getUserFollowing,
                'follower' => $getUserFollower,
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
