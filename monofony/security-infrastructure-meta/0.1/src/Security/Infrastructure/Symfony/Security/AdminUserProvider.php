<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security;

use App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity\SecurityAdminUser;
use App\Security\Infrastructure\Security\User\Canonicalizer\CanonicalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Webmozart\Assert\Assert;

final readonly class AdminUserProvider implements UserProviderInterface
{
    public function __construct(
        private CanonicalizerInterface $canonicalizer,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SecurityAdminUser) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return SecurityAdminUser::class === $class || is_subclass_of($class, SecurityAdminUser::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $identifier = $this->canonicalizer->canonicalize($identifier);
        Assert::notNull($identifier);

        $repository = $this->entityManager->getRepository(SecurityAdminUser::class);

        $user = $repository->findOneBy([
            'emailCanonical' => $identifier,
        ]);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
