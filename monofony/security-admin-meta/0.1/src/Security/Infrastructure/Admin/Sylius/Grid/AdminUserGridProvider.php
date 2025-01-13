<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Sylius\Grid;

use App\Security\Application\AdminUser\Query\FindAdminUsersQuery;
use App\Security\Domain\Repository\AdminUserRepositoryInterface;
use App\Security\Infrastructure\Admin\Sylius\Resource\AdminUserResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\Sylius\Grid\GridPageResolver;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Webmozart\Assert\Assert;

final readonly class AdminUserGridProvider implements DataProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function getData(Grid $grid, Parameters $parameters): Pagerfanta
    {
        /** @var array<string, string> $sorting */
        $sorting = $parameters->get('sorting') ?? $grid->getSorting();

        $criteria = $parameters->get('criteria') ?? [];

        /** @var AdminUserRepositoryInterface $models */
        $models = $this->queryBus->ask(new FindAdminUsersQuery(
            GridPageResolver::getCurrentPage($grid, $parameters),
            GridPageResolver::getItemsPerPage($grid, $parameters),
            emailSortingAsc: 'asc' === ($sorting['email'] ?? null) ? true : null,
            emailSortingDesc: 'desc' === ($sorting['email'] ?? null) ? true : null,
            searchQuery: !empty($criteria['search']['value'] ?? null) ? $criteria['search']['value'] : null,
        ));

        $data = [];
        foreach ($models as $model) {
            $data[] = AdminUserResource::fromModel($model);
        }

        $paginator = $models->paginator();
        Assert::notNull($paginator);

        return new Pagerfanta(new FixedAdapter($paginator->getTotalItems(), $data));
    }
}
