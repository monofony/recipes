<?php

declare(strict_types=1);

namespace App\Security\Domain\Model\User;

use App\Security\Domain\ValueObject\User\AdminUserEmail;
use App\Security\Domain\ValueObject\User\AdminUserId;
use App\Security\Domain\ValueObject\User\AdminUserPassword;

final readonly class AdminUser
{
    public function __construct(
        public AdminUserId $id,
        public AdminUserEmail $email,
        public AdminUserPassword|null $password = null,
    ) {
    }
}
