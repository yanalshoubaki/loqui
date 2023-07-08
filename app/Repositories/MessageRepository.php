<?php

namespace App\Repositories;

use App\Interfaces\MessageRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Jobs\NewMessageSendMail;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository implements MessageRepositoryInterface
{

    protected UserRepositoryInterface $userRepository;

    public function __construct( UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all messages for a user by id
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getAllMessages($id, $haveReplay = false) : Collection {
        /** @var User $user */
        $user =  $this->userRepository->getUserById($id);
        /** @var Collection $userMessages */
        $userMessages = $user->messages()->when($haveReplay, function (Builder $query) {
            $query->doesntHave('replay');
        }, function (Builder $query) {
            $query->has('replay');
        })->get();
        return $userMessages;
    }

    /**
     * Get message by id
     *
     * @param int $id
     *
     * @return Message|null
     */
    public function getMessageById(int $id): Message|null
    {
        return Message::find($id);
    }

    /**
     * Create a new message
     *
     * @param array $data
     *
     * @return Message
     */
    public function createMessage(array $data): Message
    {
        $message = new Message($data);
        $message->save();
        dispatch(new NewMessageSendMail($message));
        return $message;
    }

}
