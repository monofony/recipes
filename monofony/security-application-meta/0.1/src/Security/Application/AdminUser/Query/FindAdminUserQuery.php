<?php

declare(strict_types=1);

namespace App\Security\Application\AdminUser\Query;

use App\Shared\Application\Query\QueryInterface;

class FindAdminUserQuery implements QueryInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
