<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\EventListener;

use App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity\SecurityAdminUser;
use App\Security\Infrastructure\Security\User\Canonicalizer\CanonicalizerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::preUpdate)]
final readonly class CanonicalizerListener
{
    public function __construct(
        private CanonicalizerInterface $canonicalizer
    ) {
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $this->canonicalize($event);
    }

    public function preUpdate(LifecycleEventArgs $event): void
    {
        $this->canonicalize($event);
    }

    public function canonicalize(LifecycleEventArgs $event): void
    {
        $item = $event->getObject();

        if (!$item instanceof SecurityAdminUser) {
            return;
        }

        $item->setEmailCanonical($this->canonicalizer->canonicalize($item->getEmail()));
    }
}
