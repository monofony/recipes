<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class FindAdminUsersQuery implements QueryInterface
{
    public function __construct(
        public int|null $page = null,
        public int|null $itemsPerPage = null,
        public bool|null $emailSortingAsc = null,
        public bool|null $emailSortingDesc = null,
        public string|null $searchQuery = null,
    ) {
    }
}
