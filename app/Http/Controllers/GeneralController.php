<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GeneralController extends Controller
{

    public function __construct(public Request $request)
    {
    }

    public function getCurrentUser()
    {
        /** @var \App\Models\User $user */
        $user = $this->request->user();

        return new UserResource($user);
    }

    public function getUserStats()
    {
        /** @var \App\Models\User $user */
        $user = $this->request->user();
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

        return $stats;
    }

    public function renderInertia(string $component, array $props = [])
    {
        return Inertia::render($component, $props + [
            'user' => $this->getCurrentUser(),
            'stats' => $this->getUserStats(),
        ]);
    }
}
