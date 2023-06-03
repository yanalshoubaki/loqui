<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\NewMessageEvent;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateMessageRequest;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class MessageController extends ApiHandler
{
    public function getMessages(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user->hasDirectPermission('view Message');
            $messages = $user->messages()->get();
            return $this->getResponse($messages, 'Message success', "success");
        } catch(PermissionDoesNotExist $e) {
            return $this->getResponse(null, "You haven't permission to do this action", "error");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }

    /**
     * Send message to user
     *
     * @param CreateMessageRequest $request
     * @return JsonResponse
     */
    public function sendMessage(CreateMessageRequest $request): JsonResponse
    {

        try {
            $inputs = $request->getInputs();
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user->hasDirectPermission('create Message');
            /** @var \App\Models\User $receiverUser */
            $receiverUser = User::where('id', $inputs['receiver_id'])->first();
            /** @var \App\Models\Message $message */
            $message = $receiverUser->messages()->create([
                'sender_id' => $user->id,
                ...$inputs
            ]);
            event(new NewMessageEvent($message));
            return $this->getResponse($message, "Message Created", "success");
        } catch(PermissionDoesNotExist $e) {
            return $this->getResponse(null, "You haven't permission to do this action", "error");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }


    /**
     * Delete message
     *
     * @param Request $request
     * @param Message $message
     * @return JsonResponse
     */
    public function deleteMessage(Request $request, Message $message): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user->hasDirectPermission('delete Message');
            if ($user->id != $message->sender_id) {
                throw ValidationException::withMessages([
                    'message' => "You can't delete this message"
                ]);
            }
            $message->delete();
            return $this->getResponse(null, "Message Deleted", "success");
        } catch(PermissionDoesNotExist $e) {
            return $this->getResponse(null, "You haven't permission to do this action", "error");
        } catch (\Throwable $th) {
            return $this->getResponse(null, $th->getMessage(), "error");
        }
    }
}
