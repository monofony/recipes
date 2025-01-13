<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Command;

use App\Shared\Application\Command\CommandInterface;

final class DeleteAdminUserCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
