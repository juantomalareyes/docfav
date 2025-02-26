<?php

namespace Tests\Unit\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObjects\Name;
use InvalidArgumentException;

class NameTest extends TestCase
{
    public function testNameIsCreatedSuccessfully()
    {
        $name = new Name('Juan Pérez');
        $this->assertEquals('Juan Pérez', (string) $name->value());
    }

    public function testNameThrowsExceptionForEmptyValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new Name('');
    }

    public function testNameThrowsExceptionForTooShortName()
    {
        $this->expectException(InvalidArgumentException::class);
        new Name('A'); // Menos de 2 caracteres
    }

    public function testNameThrowsExceptionOnlyAllowsLetters()
    {
        $this->expectException(InvalidArgumentException::class);
        new Name('?'); 
    }
}