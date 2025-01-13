<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Command;

use App\Security\Domain\Model\User\AdminUser;
use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Security\Domain\ValueObject\User\AdminUserId;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class UpdateAdminUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository,
    ) {
    }

    public function __invoke(UpdateAdminUserCommand $command): AdminUser
    {
        $adminUser = new AdminUser(
            new AdminUserId($command->id),
            $command->email,
            $command->password,
        );

        $this->adminUserRepository->save($adminUser);

        return $adminUser;
    }
}
