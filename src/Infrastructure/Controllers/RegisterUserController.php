<?php

namespace App\Infrastructure\Controllers;

use App\Application\DTO\RegisterUserRequest;
use App\Application\UseCases\RegisterUserUseCase;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\Exceptions\InvalidEmailException;
use App\Domain\Exceptions\WeakPasswordException;
use Exception;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function handle(): void
    {
        header('Content-Type: application/json');

        try {
            $requestData = json_decode(file_get_contents("php://input"), true);

            if (!$requestData || !isset($requestData['name'], $requestData['email'], $requestData['password'])) {
                throw new Exception("Datos inválidos. Se requiere name, email y password.");
            }

            $requestDTO = new RegisterUserRequest(
                $requestData['name'],
                $requestData['email'],
                $requestData['password']
            );

            $userResponseDTO = $this->registerUserUseCase->execute($requestDTO);

            echo json_encode([
                'success' => true,
                'user' => $userResponseDTO->toArray()
            ]);
        } catch (UserAlreadyExistsException | InvalidEmailException | WeakPasswordException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } //catch (Exception $e) {
        //     http_response_code(500);
        //     echo json_encode(['error' => 'Error interno del servidor.']);
        // }
    }
}