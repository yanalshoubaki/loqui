<?php

namespace App\Interfaces;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

interface MessageRepositoryInterface
{

    /**
     * Get all messages for a user by id
     *
     * @param int $id
     * @param bool $haveReplay
     *
     * @return Collection
     */
    public function getAllMessages(int $id, bool $haveReplay): Collection;


    /**
     * Get message by id
     *
     * @param int $id
     *
     * @return Message|null
     */
    public function getMessageById(int $id): Message|null;

    /**
     * Create a new message
     *
     * @param array $data
     *
     * @return Message
     */
    public function createMessage(array $data): Message;
}
