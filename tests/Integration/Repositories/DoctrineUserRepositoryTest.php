<?php

namespace Tests\Integration\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        require __DIR__ . '/../../../src/Config/bootstrap_test.php';

        $this->entityManager = $entityManager;
        $this->userRepository = new DoctrineUserRepository($this->entityManager);

        // Limpiar la base de datos antes de cada prueba
        $this->entityManager->createQuery('DELETE FROM App\Domain\Entities\User')->execute();
    }

    public function testSaveAndFindUser(): void
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

        $this->userRepository->save($user);
        $foundUser = $this->userRepository->findById($userId);

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->getEmail(), $foundUser->getEmail());
    }

    public function testDeleteUser(): void
    {
        $userId = new UserId();
        $name = new Name("Maria López");
        $email = new Email("jmaria@example.com");
        $password = new Password("StrongPass456!");

        $user = new User(
            $userId->value(),
            $name->value(),
            $email->value(),
            $password->value()
        );

        $this->userRepository->save($user);
        $this->userRepository->delete($userId);

        $foundUser = $this->userRepository->findById($userId);
        $this->assertNull($foundUser);
    }

    public function testFindNonExistentUser(): void
    {
        $nonExistentId = new UserId();
        $user = $this->userRepository->findById($nonExistentId);

        $this->assertNull($user);
    }
}