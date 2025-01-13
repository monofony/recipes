<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Doctrine\Listener;

use App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity\SecurityAdminUser;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::preUpdate)]
final readonly class HashAdminUserPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $this->hashPassword($event);
    }

    public function preUpdate(LifecycleEventArgs $event): void
    {
        $this->hashPassword($event);
    }

    private function hashPassword(LifecycleEventArgs $event): void
    {
        $item = $event->getObject();

        if (!$item instanceof SecurityAdminUser || null === $item->getPlainPassword()) {
            return;
        }

        $item->setPassword($this->passwordHasher->hashPassword($item, $item->getPlainPassword()));
        $item->eraseCredentials();
    }
}
