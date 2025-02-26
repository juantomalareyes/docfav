<?php

namespace App\Domain\Events;

use App\Domain\ValueObjects\UserId;

class UserRegisteredEvent
{
    private UserId $userId;
    private string $email;

    public function __construct(UserId $userId, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): string
    {
        return $this->email;
    }
}