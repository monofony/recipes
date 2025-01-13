<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Admin\Sylius\Grid;

use App\Security\Infrastructure\Persistence\Doctrine\ORM\Entity\SecurityAdminUser;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class AdminUserGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    #[\Override]
    public static function getName(): string
    {
        return 'app_security_admin_user';
    }

    #[\Override]
    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setProvider(AdminUserGridProvider::class)
            ->addFilter(
                StringFilter::create('search')
                    ->setLabel('sylius.ui.search')
                    ->setFormOptions([
                        'type' => 'contains',
                    ])
            )
            ->orderBy('email', 'desc')
            ->addField(
                StringField::create('email')
                    ->setLabel('app.ui.email')
                    ->setSortable(true)
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create()
                )
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    UpdateAction::create(),
                    DeleteAction::create(),
                )
            )
//            ->addActionGroup(BulkActionGroup::create(DeleteAction::create()))
        ;
    }

    #[\Override]
    public function getResourceClass(): string
    {
        return SecurityAdminUser::class;
    }
}
