<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\UserFollow;
use Illuminate\Http\Request;

class HomeController extends GeneralController
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = $request->user();

        if ($currentUser->hasRole('admin')) {
            return redirect()->route('home');
        }

        /** @var \Illuminate\Database\Eloquent\Collection $getUserFollowing */
        $getUserFollowing = $currentUser->following()->get();
        /** @var \Illuminate\Database\Eloquent\Collection $getUserFollower */
        $getUserFollower = $currentUser->follower()->get();
        /** @var \Illuminate\Database\Eloquent\Collection $getMessages */
        $getMessages = $currentUser->messages()->get();

        $getMessages->each(function (Message $message) {
            $message->load('user');
        });

        $getUserFollowing->each(function (UserFollow $follower) {
            $follower->load('user');
        });

        /** @var \Illuminate\Database\Eloquent\Collection $getMessages */
        $getMessagesByFollowing = $currentUser->messages()->whereIn('user_id', $getUserFollowing->pluck('user_id'))->whereHas('replay')->get();

        return $this->renderInertia('Home', [
            'messages' => MessageResource::collection($getMessagesByFollowing),
        ]);
    }
}
