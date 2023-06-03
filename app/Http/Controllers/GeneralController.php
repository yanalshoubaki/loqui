<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class GeneralController extends Controller
{

    public $redis;

    public function __construct(public Request $request)
    {
        $this->redis = Redis::connection();
    }

    public function getCurrentUser()
    {


        /** @var \App\Models\User $user */
        $requestUser = $this->request->user();
        $resource = new UserResource($requestUser);
        $this->redis->set('user:data:' . $requestUser->id, json_encode($resource));
        $user = $this->redis->get('user:data:' . $requestUser->id);
        return json_decode($user);
    }

    public function getUserStats()
    {
        /** @var \App\Models\User $user */
        $user = $this->request->user();
        /** @var \Illuminate\Database\Eloquent\Collection $getUserFollowing */
        $getUserFollowing = $user->following()->get();
        /** @var \Illuminate\Database\Eloquent\Collection $getUserFollower  */
        $getUserFollower = $user->follower()->get();
        /** @var \Illuminate\Database\Eloquent\Collection $getMessages */
        $getMessages = $user->messages()->get();
        $stats = [
            'following' => $getUserFollowing->count(),
            'messages' => $getMessages->count(),
            'followers' => $getUserFollower->count(),
        ];
        $this->redis->set('user:data:stats:' . $user->id, json_encode($stats));
        $stats = $this->redis->get('user:data:stats:' . $user->id);

        return json_decode($stats);
    }

    public function renderInertia(string $component, array $props = [])
    {
        return Inertia::render($component, $props + [
            'user' => $this->getCurrentUser(),
            'stats' => $this->getUserStats(),
        ]);
    }
}
