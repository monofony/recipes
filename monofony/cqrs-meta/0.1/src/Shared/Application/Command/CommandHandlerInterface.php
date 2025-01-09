<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(
    name: 'messenger.message_handler',
    attributes: [
        'bus' => 'command.bus',
    ],
)]
interface CommandHandlerInterface
{
}
