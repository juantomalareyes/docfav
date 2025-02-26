<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id->value());
    }

    public function delete(UserId $id): void
    {
        $user = $this->findById($id);
        if (!$user) {
            throw new EntityNotFoundException("Usuario no encontrado");
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function existsByEmail(string $email): bool
    {
        $query = $this->entityManager->createQuery(
            'SELECT COUNT(u.id) FROM App\Domain\Entities\User u WHERE u.email = :email'
        )->setParameter('email', $email);

        return (int) $query->getSingleScalarResult() > 0;
    }
}