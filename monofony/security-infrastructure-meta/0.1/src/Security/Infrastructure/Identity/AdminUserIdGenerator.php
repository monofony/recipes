<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Identity;

use App\Security\Domain\ValueObject\User\AdminUserId;
use App\Shared\Infrastructure\Generator\GeneratorInterface;

final readonly class AdminUserIdGenerator
{
    public function __construct(
        private GeneratorInterface $generator,
    ) {
    }

    public function nextIdentity(): AdminUserId
    {
        return new AdminUserId($this->generator::generate());
    }
}
