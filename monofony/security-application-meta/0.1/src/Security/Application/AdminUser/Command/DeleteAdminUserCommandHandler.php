<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Command;

use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class DeleteAdminUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository
    ) {
    }

    public function __invoke(DeleteAdminUserCommand $command): void
    {
        if (null === $boardGame = $this->adminUserRepository->ofId($command->id)) {
            return;
        }

        $this->adminUserRepository->remove($boardGame);
    }
}
