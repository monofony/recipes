<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Processor;

use App\Security\Application\AdminUser\Command\CreateAdminUserCommand;
use App\Security\Domain\Model\User\AdminUser;
use App\Security\Domain\ValueObject\User\AdminUserEmail;
use App\Security\Domain\ValueObject\User\AdminUserPassword;
use App\Security\Infrastructure\Admin\Sylius\Resource\AdminUserResource;
use App\Shared\Application\Command\CommandBusInterface;
use Sylius\Resource\Context\Context;
use Sylius\Resource\Metadata\Operation;
use Sylius\Resource\State\ProcessorInterface;
use Webmozart\Assert\Assert;

final readonly class CreateAdminUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param AdminUserResource|mixed $data
     */
    public function process(mixed $data, Operation $operation, Context $context): AdminUserResource
    {
        Assert::isInstanceOf($data, AdminUserResource::class);

        Assert::notNull($data->email);
        Assert::notNull($data->plainPassword);

        $command = new CreateAdminUserCommand(
            new AdminUserEmail($data->email),
            new AdminUserPassword($data->plainPassword),
        );

        /** @var AdminUser $model */
        $model = $this->commandBus->dispatch($command);

        return AdminUserResource::fromModel($model);
    }
}
