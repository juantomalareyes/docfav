<?php

namespace Tests\Unit\ValueObjects;

use App\Domain\ValueObjects\Password;
use App\Domain\Exceptions\WeakPasswordException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testValidPassword(): void
    {
        $password = new Password("SecurePass123!");
        $this->assertNotEmpty($password->value());
    }

    public function testWeakPasswordThrowsException(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password("weak");
    }
}