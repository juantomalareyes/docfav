<?php

namespace App\Application\UseCases;

use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;
use App\Domain\Events\UserRegisteredEvent;
use App\Domain\Exceptions\UserAlreadyExistsException;
use Psr\EventDispatcher\EventDispatcherInterface;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        if ($this->userRepository->existsByEmail($request->email)) {
            throw new UserAlreadyExistsException("El usuario con email {$request->email} ya existe.");
        }

        $userId = new UserId();
        $name = new Name($request->name);
        $email = new Email($request->email);
        $password = new Password($request->password);        

        $user = new User(
            $userId->value(),
            $name->value(),
            $email->value(),
            $password->value()
        );

        $this->userRepository->save($user);

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($userId, $email->value()));

        return new UserResponseDTO($user->getId(), $user->getName(), $user->getEmail());
    }
}