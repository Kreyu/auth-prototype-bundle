<?php

declare(strict_types=1);

namespace Kreyu\Bundle\AuthPrototypeBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    public readonly string $email;

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        // ...
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
