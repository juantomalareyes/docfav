<?php

namespace App\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /** @ORM\Id @ORM\Column(type="string", length=100) */
    private $id;

    /** @ORM\Column(type="string", length=150) */
    private $name;

    /** @ORM\Column(type="string", length=255, unique=true) */
    private $email;

    /** @ORM\Column(type="string", length=255) */
    private $password;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    public function __construct(string $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new \DateTime();
    }

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
}