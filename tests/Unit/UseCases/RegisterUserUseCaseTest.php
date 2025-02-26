<?php

namespace Tests\Unit\UseCases;

use App\Application\DTO\RegisterUserRequest;
use App\Application\UseCases\RegisterUserUseCase;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Events\UserRegisteredEvent;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepository;
    private $eventDispatcher;
    private $useCase;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->useCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    public function testRegisterUserSuccessfully(): void
    {
        $request = new RegisterUserRequest("Juan Pérez", "juan@example.com", "SecurePass123!");

        $this->userRepository->method('findById')->willReturn(null);
        $this->userRepository->expects($this->once())->method('save');

        $this->eventDispatcher->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UserRegisteredEvent::class));

        $response = $this->useCase->execute($request);

        $this->assertEquals("juan@example.com", $response->email);
    }

    public function testRegisterUserFailsIfEmailExists(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('existsByEmail')->willReturn(true);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $useCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

        $this->expectException(UserAlreadyExistsException::class);
        $this->expectExceptionMessage("El usuario con email test@example.com ya existe.");

        $request = new RegisterUserRequest('John Doe', 'test@example.com', 'Password123!');
        $useCase->execute($request);
    }
}