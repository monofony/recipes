<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Fixture\DataFixtures;

use App\Security\Infrastructure\Persistence\Fixture\Story\DefaultAdministratorsStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DefaultFixtures extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        DefaultAdministratorsStory::load();
    }

    #[\Override]
    public static function getGroups(): array
    {
        return ['default', 'security'];
    }

    #[\Override]
    public function getOrder(): int
    {
        return 1;
    }
}
