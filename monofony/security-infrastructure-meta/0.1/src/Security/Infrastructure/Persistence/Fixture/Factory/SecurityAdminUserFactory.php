<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Fixture\Factory;

use App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity\SecurityAdminUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Webmozart\Assert\Assert;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<SecurityAdminUser>
 */
final class SecurityAdminUserFactory extends PersistentProxyObjectFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
        parent::__construct();
    }

    #[\Override]
    public static function class(): string
    {
        return SecurityAdminUser::class;
    }

    public function withEmail(string $email): self
    {
        return $this->with([
            'email' => $email,
        ]);
    }

    public function withPassword(string $password): self
    {
        return $this->with([
            'password' => $password,
        ]);
    }

    #[\Override]
    protected function defaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'password' => 'password',
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (SecurityAdminUser $user) {
                Assert::notNull($user->getPassword());
                $password = $this->userPasswordHasher->hashPassword($user, $user->getPassword());

                $user->setPassword($password);
            })
        ;
    }

    protected function getStart(string $email, string $username, string $password): array
    {
        return [
            'email' => $email,
            'password' => $password,
        ];
    }
}
