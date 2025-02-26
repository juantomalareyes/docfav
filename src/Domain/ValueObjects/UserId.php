<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UserId
{
    private string $value;

    public function __construct(string $id = null)
    {
        $this->value = $id ?? Uuid::uuid4()->toString();
        
        if (!Uuid::isValid($this->value)) {
            throw new InvalidArgumentException("ID de usuario inválido");
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}