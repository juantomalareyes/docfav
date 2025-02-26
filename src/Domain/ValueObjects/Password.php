<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\WeakPasswordException;

class Password {
    private string $password;

    public function __construct(string $password) {
        if (!$this->isValid($password)) {
            throw new WeakPasswordException("La contraseña no cumple con los requisitos de seguridad. Mínimo 8 caracteres y al menos una letra mayúscula, un número y un carácter especial.");
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    private function isValid(string $password): bool {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    public function value(): string {
        return $this->password;
    }
}