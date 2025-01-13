<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Query;

use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class FindAdminUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository,
    ) {
    }

    public function __invoke(FindAdminUsersQuery $query): AdminUserRepositoryInterface
    {
        $adminUserRepository = $this->adminUserRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $adminUserRepository = $adminUserRepository->withPagination($query->page, $query->itemsPerPage);
        }

        if ($query->emailSortingAsc) {
            $adminUserRepository = $adminUserRepository->withAscendingEmailSorting();
        }

        if ($query->emailSortingDesc) {
            $adminUserRepository = $adminUserRepository->withDescendingEmailSorting();
        }

        if (null !== $query->searchQuery) {
            $adminUserRepository = $adminUserRepository->withSearchQuery($query->searchQuery);
        }

        return $adminUserRepository;
    }
}
