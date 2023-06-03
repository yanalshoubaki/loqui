<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends GeneralController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
        } catch (\Throwable $th) {
            //throw $th;
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
    public function show(User $user)
    {
        $currentUser = $this->getCurrentUser();
        if ($currentUser['id'] != $user->id) {
            /** @var \Illuminate\Database\Eloquent\Collection $getUserFollowing  */
            $getUserFollowing = $user->following()->get();
            /** @var \Illuminate\Database\Eloquent\Collection $getUserFollower  */
            $getUserFollower = $user->follower()->get();
            /** @var \Illuminate\Database\Eloquent\Collection $getMessages  */
            $getMessages = $user->messages()->get();
            $stats = [
                'following' => $getUserFollowing->count(),
                'messages' => $getMessages->count(),
                'followers' => $getUserFollower->count()
            ];

            return $this->renderInertia('User/Sent', [
                'stats' => $stats,
                'user' => new UserResource($user),
                'currentUser' => $currentUser,
            ]);
        }
        return $this->renderInertia('User/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
