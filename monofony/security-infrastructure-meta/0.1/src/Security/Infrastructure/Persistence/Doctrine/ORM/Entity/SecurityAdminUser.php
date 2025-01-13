<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_admin_user')]
class SecurityAdminUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid|null $id;

    #[ORM\Column]
    private string|null $email = null;

    #[ORM\Column]
    private string|null $emailCanonical = null;

    #[ORM\Column]
    private string|null $password = null;

    #[ORM\Column]
    private array $roles = [self::DEFAULT_ADMIN_ROLE];

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private \DateTimeInterface|null $updatedAt = null;

    private string|null $plainPassword = null;

    /** @api */
    final public const string DEFAULT_ADMIN_ROLE = 'ROLE_ADMIN';

    public function __construct(Uuid|null $id = null)
    {
        $this->id = $id;
    }

    public function getId(): Uuid|null
    {
        return $this->id;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function setEmail(string|null $email): void
    {
        $this->email = $email;
    }

    public function getEmailCanonical(): string|null
    {
        return $this->emailCanonical;
    }

    public function setEmailCanonical(string|null $emailCanonical): void
    {
        $this->emailCanonical = $emailCanonical;
    }

    #[\Override]
    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string|null $password): void
    {
        $this->password = $password;
    }

    public function getPlainPassword(): string|null
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string|null $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[\Override]
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    #[\Override]
    public function getUserIdentifier(): string
    {
        $username = $this->getEmail();
        Assert::notNull($username);
        Assert::stringNotEmpty($username);

        return $username;
    }

    #[\Override]
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
