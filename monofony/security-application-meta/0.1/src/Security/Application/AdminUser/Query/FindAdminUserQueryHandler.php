<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Query;

use App\Security\Domain\Model\User\AdminUser;
use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class FindAdminUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AdminUserRepositoryInterface $repository
    ) {
    }

    public function __invoke(FindAdminUserQuery $query): AdminUser|null
    {
        return $this->repository->ofId($query->id);
    }
}
