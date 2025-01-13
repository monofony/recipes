<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Sylius\State\AdminUser\Provider;

use App\Security\Application\AdminUser\Query\FindAdminUserQuery;
use App\Security\Infrastructure\Admin\Sylius\Resource\AdminUserResource;
use App\Shared\Application\Query\QueryBusInterface;
use Sylius\Resource\Context\Context;
use Sylius\Resource\Context\Option\RequestOption;
use Sylius\Resource\Metadata\Operation;
use Sylius\Resource\State\ProviderInterface;
use Webmozart\Assert\Assert;

final class AdminUserItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, Context $context): AdminUserResource|null
    {
        $request = $context->get(RequestOption::class)?->request();
        Assert::notNull($request);

        $id = (string) $request->attributes->get('id');

        $model = $this->queryBus->ask(new FindAdminUserQuery($id));

        return null !== $model ? AdminUserResource::fromModel($model) : null;
    }
}
