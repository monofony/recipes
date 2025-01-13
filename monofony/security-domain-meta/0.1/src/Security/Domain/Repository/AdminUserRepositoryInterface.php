<?php

declare(strict_types=1);

namespace App\Security\Domain\Repository;

use App\Security\Domain\Model\User\AdminUser;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<AdminUser>
 */
interface AdminUserRepositoryInterface extends RepositoryInterface
{
    public function save(AdminUser $adminUser): void;

    public function remove(AdminUser $adminUser): void;

    public function ofId(string $id): AdminUser|null;

    public function withAscendingEmailSorting(): static;

    public function withDescendingEmailSorting(): static;

    public function withSearchQuery(string $query): static;
}
