<?php

declare(strict_types=1);

namespace App\Tests\Shared\Application\Command;

use App\Book\Application\Command\BookCommandHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CommandHandlerTest extends KernelTestCase
{
    public function testBookCommandHandlerIsRegistered(): void
    {
        $this->assertTrue($this->getContainer()->has(BookCommandHandler::class));
    }
}
