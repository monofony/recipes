<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Persistence\Doctrine\ORM\Repository;

use App\Security\Domain\Model\User\AdminUser;
use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Security\Domain\ValueObject\User\AdminUserEmail;
use App\Security\Domain\ValueObject\User\AdminUserId;
use App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity\SecurityAdminUser;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Uuid;

/**
 * @extends DoctrineRepository<AdminUser>
 */
class DoctrineAdminUserRepository extends DoctrineRepository implements AdminUserRepositoryInterface
{
    private const ENTITY_CLASS = SecurityAdminUser::class;
    private const ALIAS = 'admin_user';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(AdminUser $adminUser): void
    {
        $securityAdminUser = $this->transformUserFromModel($adminUser);

        $this->em->persist($securityAdminUser);
        $this->em->flush();
        $this->em->refresh($securityAdminUser);
    }

    public function remove(AdminUser $adminUser): void
    {
        $securityAdminUser = $this->transformUserFromModel($adminUser);

        $this->em->remove($securityAdminUser);
        $this->em->flush();
    }

    public function ofId(string $id): AdminUser|null
    {
        $securityAdminUser = $this->em->find(self::ENTITY_CLASS, $id);

        if (null === $securityAdminUser) {
            return null;
        }

        $adminUser = new AdminUser(
            new AdminUserId($securityAdminUser->getId()?->toString() ?? ''),
            new AdminUserEmail($securityAdminUser->getEmail() ?? ''),
            null,
        );

        return $adminUser;
    }

    public function withAscendingEmailSorting(): static
    {
        return $this->filter(static function (QueryBuilder $queryBuilder): void {
            $queryBuilder->orderBy(sprintf('%s.email', self::ALIAS), 'ASC');
        });
    }

    public function withDescendingEmailSorting(): static
    {
        return $this->filter(static function (QueryBuilder $queryBuilder): void {
            $queryBuilder->orderBy(sprintf('%s.email', self::ALIAS), 'DESC');
        });
    }

    public function withSearchQuery(string $query): static
    {
        return $this->filter(static function (QueryBuilder $queryBuilder) use ($query): void {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like(sprintf('%s.email', self::ALIAS), ':query'))
                ->setParameter('query', '%' . $query . '%')
            ;
        });
    }

    public function getIterator(): \Iterator
    {
        /** @var SecurityAdminUser $entity */
        foreach (parent::getIterator() as $entity) {
            yield $this->transformEntityToModel($entity);
        }
    }

    private function transformUserFromModel(AdminUser $adminUser): SecurityAdminUser
    {
        $securityAdminUser = $this->em->find(self::ENTITY_CLASS, $adminUser->id->value);

        if (null === $securityAdminUser) {
            $securityAdminUser = new SecurityAdminUser(Uuid::fromString($adminUser->id->value));
        }

        $securityAdminUser->setEmail($adminUser->email->value);
        $securityAdminUser->setPlainPassword($adminUser->password?->value);

        return $securityAdminUser;
    }

    private function transformEntityToModel(SecurityAdminUser $securityAdminUser): AdminUser
    {
        return new AdminUser(
            id: new AdminUserId((string) $securityAdminUser->getId()),
            email: new AdminUserEmail($securityAdminUser->getEmail() ?? ''),
        );
    }
}
