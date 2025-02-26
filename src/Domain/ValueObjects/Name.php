<?php

namespace App\Domain\ValueObjects;

class Name {
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidName($value);
        $this->value = $value;
    }

    private function ensureIsValidName(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('El nombre no puede estar vacío.');
        }

        if (strlen($value) < 2) {
            throw new \InvalidArgumentException('El nombre es demasiado corto.');
        }

        if (!preg_match('/^[\p{L}\s]+$/u', $value)) {
            throw new \InvalidArgumentException("El nombre solo puede contener letras y espacios.");
        }
    }

    public function value(): string {
        return $this->value;
    }

    // private string $name;

    // public function __construct(string $name) {
    //     if (empty(trim($name))) {
    //         throw new \InvalidArgumentException("El nombre no puede estar vacío.");
    //     }

    //     if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
    //         throw new \InvalidArgumentException("El nombre solo puede contener letras y espacios.");
    //     }

    //     $this->name = $name;
    // }

    // public function value(): string {
    //     return $this->name;
    // }
}