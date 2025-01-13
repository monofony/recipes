<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Command;

use App\Security\Domain\Model\User\AdminUser;
use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Security\Infrastructure\Identity\AdminUserIdGenerator;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class CreateAdminUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AdminUserIdGenerator $generator,
        private AdminUserRepositoryInterface $adminUserRepository,
    ) {
    }

    public function __invoke(CreateAdminUserCommand $command): AdminUser
    {
        $adminUser = new AdminUser(
            $this->generator->nextIdentity(),
            $command->email,
            $command->password,
        );

        $this->adminUserRepository->save($adminUser);

        return $adminUser;
    }
}
