<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Processor;

use App\Security\Application\AdminUser\Command\DeleteAdminUserCommand;
use App\Security\Infrastructure\Admin\Sylius\Resource\AdminUserResource;
use App\Shared\Application\Command\CommandBusInterface;
use Sylius\Resource\Context\Context;
use Sylius\Resource\Metadata\Operation;
use Sylius\Resource\State\ProcessorInterface;
use Webmozart\Assert\Assert;

final readonly class DeleteAdminUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, Context $context): null
    {
        Assert::isInstanceOf($data, AdminUserResource::class);

        $this->commandBus->dispatch(new DeleteAdminUserCommand((string) $data->id));

        return null;
    }
}
