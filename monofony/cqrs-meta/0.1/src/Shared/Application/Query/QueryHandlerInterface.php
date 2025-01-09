<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(
    name: 'messenger.message_handler',
    attributes: [
        'bus' => 'query.bus',
    ],
)]
interface QueryHandlerInterface
{
}
