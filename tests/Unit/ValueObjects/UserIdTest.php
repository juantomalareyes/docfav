<?php

namespace Tests\Unit\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObjects\UserId;
use InvalidArgumentException;

class UserIdTest extends TestCase
{
    public function testUserIdIsCreatedSuccessfully()
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $userId = new UserId($uuid);
        $this->assertEquals($uuid, (string) $userId->value());
    }

    public function testUserIdThrowsExceptionForInvalidUuid()
    {
        $this->expectException(InvalidArgumentException::class);
        new UserId('invalid-uuid');
    }
}