<?php

namespace Tests\Unit\ValueObjects;

use App\Domain\ValueObjects\Email;
use App\Domain\Exceptions\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email("test@example.com");
        $this->assertEquals("test@example.com", $email->value());
    }

    public function testInvalidEmailThrowsException(): void
    {
        $this->expectException(InvalidEmailException::class);
        new Email("invalid-email");
    }
}