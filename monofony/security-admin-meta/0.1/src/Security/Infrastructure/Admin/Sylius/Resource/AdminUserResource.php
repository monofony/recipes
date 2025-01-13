<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Sylius\Resource;

use App\Security\Domain\Model\User\AdminUser;
use App\Security\Infrastructure\Admin\Sylius\Grid\AdminUserGrid;
use App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Processor\CreateAdminUserProcessor;
use App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Processor\DeleteAdminUserProcessor;
use App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Processor\UpdateAdminUserProcessor;
use App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Provider\AdminUserItemProvider;
use App\Security\Infrastructure\Admin\Symfony\Form\Type\AdminUserType;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Create;
use Sylius\Resource\Metadata\Delete;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Metadata\Update;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin_security',
    formType: AdminUserType::class,
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: 'admin/security',
    driver: false,
    operations: [
        new Create(
            processor: CreateAdminUserProcessor::class,
        ),
        new Update(
            provider: AdminUserItemProvider::class,
            processor: UpdateAdminUserProcessor::class,
        ),
        new Delete(
            provider: AdminUserItemProvider::class,
            processor: DeleteAdminUserProcessor::class,
        ),
        new Index(
            grid: AdminUserGrid::class,
        ),
    ],
)]
class AdminUserResource implements ResourceInterface
{
    public function __construct(
        public string|null $id = null,
        public string|null $email = null,
        #[\SensitiveParameter]
        public string|null $plainPassword = null,
    ) {
    }

    public static function fromModel(AdminUser $user): self
    {
        return new self(
            $user->id->value,
            $user->email->value,
            $user->password?->value,
        );
    }

    #[\Override]
    public function getId(): string|null
    {
        return $this->id;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }
}
