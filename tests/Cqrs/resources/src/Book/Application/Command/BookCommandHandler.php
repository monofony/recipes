<?php

declare(strict_types=1);

namespace App\Book\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;

final class BookCommandHandler implements CommandHandlerInterface
{
    public function __invoke(BookCommand $command): void
    {
    }
}
