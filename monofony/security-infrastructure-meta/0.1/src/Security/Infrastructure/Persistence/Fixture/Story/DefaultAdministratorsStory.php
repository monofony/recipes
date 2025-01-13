<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Fixture\Story;

use App\Security\Infrastructure\Persistence\Fixture\Factory\SecurityAdminUserFactory;
use Zenstruck\Foundry\Story;

final class DefaultAdministratorsStory extends Story
{
    #[\Override]
    public function build(): void
    {
        SecurityAdminUserFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);
    }
}
