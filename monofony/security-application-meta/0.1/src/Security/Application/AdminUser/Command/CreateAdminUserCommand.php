<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Command;

use App\Security\Domain\ValueObject\User\AdminUserEmail;
use App\Security\Domain\ValueObject\User\AdminUserPassword;
use App\Shared\Application\Command\CommandInterface;

final class CreateAdminUserCommand implements CommandInterface
{
    public function __construct(
        public AdminUserEmail $email,
        public AdminUserPassword $password,
    ) {
    }
}
