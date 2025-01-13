<?php

declare(strict_types=1);

namespace App\Security\Domain\ValueObject\User;

final readonly class AdminUserEmail
{
    public function __construct(
        public string $value,
    ) {
    }
}
