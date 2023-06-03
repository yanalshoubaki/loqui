<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebRequest\CreateMessageReplayRequest;
use App\Http\Requests\WebRequest\CreateMessageRequest;
use App\Http\Resources\MessageReplayResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends GeneralController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            /** @var \App\Models\User $user */
            $user = $this->getCurrentUser();

            $messages = Message::where('user_id', $user->id)
                ->whereHas('replay')->with('replay', function ($query) {
                    $query->orderBy('created_at', 'desc')->first();
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return $this->renderInertia('Message/Index', [
                'messages' => MessageResource::collection($messages),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function inbox()
    {
        try {
            /** @var \App\Models\User $user */
            $user = $this->getCurrentUser();

            $messages = Message::where('user_id', $user->id)
                ->whereDoesntHave('replay')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return $this->renderInertia('Message/Inbox', [
                'messages' => MessageResource::collection($messages),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addReplay(CreateMessageReplayRequest $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = $this->getCurrentUser();
            $inputs = $request->getInputs();

            $message = Message::where('user_id', $user->id)
                ->where('id', $inputs['message_id'])
                ->first();

            if (!$message) {
                return $this->responseError('Message not found');
            }

            $isCreated = $message->replay()->create($inputs);
            if (!$isCreated) {
                return $this->responseError('Message replay not created');
            }
            return redirect()->route('messages.index');
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
    public function store(CreateMessageRequest $request)
    {
        try {
            $currentUser = $this->getCurrentUser();
            $inputs = $request->getInputs();

            $isCreated = Message::create($inputs);
            if (!$isCreated) {
                return $this->responseError('Message replay not created');
            }
            return redirect()->route("user.show", [
                'user' => $isCreated->user
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
