<?php

namespace Tests\Unit\Entities;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $userId = new UserId();
        $name = new Name("Juan Pérez");
        $email = new Email("juan@example.com");
        $password = new Password("SecurePass123!");

        $user = new User(
            $userId->value(),
            $name->value(),
            $email->value(),
            $password->value()
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals("Juan Pérez", $user->getName());
        $this->assertEquals("juan@example.com", $user->getEmail());
    }
}
