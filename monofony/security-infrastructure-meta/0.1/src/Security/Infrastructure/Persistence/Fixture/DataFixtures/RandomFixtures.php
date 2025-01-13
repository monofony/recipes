<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Fixture\DataFixtures;

use App\Security\Infrastructure\Persistence\Fixture\Story\RandomAdministratorsStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RandomFixtures extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        RandomAdministratorsStory::load();
    }

    #[\Override]
    public static function getGroups(): array
    {
        return ['random', 'security'];
    }

    #[\Override]
    public function getOrder(): int
    {
        return 1;
    }
}
