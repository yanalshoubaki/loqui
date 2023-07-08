<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\Message\SendMessageRequest;
use App\Interfaces\MessageRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessageController extends Handler
{

    protected MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Get all messages for a user by id and has replay
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllMessagesWithReplay(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $messages = Cache::store('redis')->remember('user:' . $currentUser->id . ":messages:with_replay", 60, function () use ($currentUser) {
            return $this->messageRepository->getAllMessages($currentUser->id, false);
        });
        return $this->responseSuccess($messages);
    }


    /**
     * Get all messages for a user by id and has no replay
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMessagesWithoutReplay(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $messages = $this->messageRepository->getAllMessages($currentUser->id, true);
        $messages = Cache::store('redis')->remember('user:' . $currentUser->id . ":messages:without_replay", 60, function () use ($currentUser) {
            return $this->messageRepository->getAllMessages($currentUser->id, true);
        });
        return $this->responseSuccess($messages);
    }

    public function getMessageById(Request $request, int $id): JsonResponse
    {
        $currentUser = $request->user();
        $message = Cache::store('redis')->remember('user:' . $currentUser->id . ":message:" . $id, 60, function () use ($id) {
            $message = $this->messageRepository->getMessageById($id);
            return $message;
        });
        if ($message === null) {
            return $this->responseError("Message not found", 404);
        }
        return $this->responseSuccess($message);
    }

    /**
     * Create a new message
     *
     * @param SendMessageRequest $request
     *
     * @return JsonResponse
     */
    public function sendMessage(SendMessageRequest $request) : JsonResponse {
        try {
            $currentUser = $request->user();
            if ($currentUser->id != $request->sender_id) {
                return $this->responseError("Sender id must be matching with the current user authenticated", 400);
            }
            $message = $this->messageRepository->createMessage($request->validated());
            return $this->responseSuccess($message);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), 500);
        }
    }
}
