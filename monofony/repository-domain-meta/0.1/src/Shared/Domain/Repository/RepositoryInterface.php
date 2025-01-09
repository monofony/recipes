<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

/**
 * @template T of object
 *
 * @extends \IteratorAggregate<array-key, T>
 */
interface RepositoryInterface extends \IteratorAggregate, \Countable
{
    /**
     * @return \Iterator<T>
     */
    public function getIterator(): \Iterator;

    public function count(): int;

    /**
     * @return PaginatorInterface<T>|null
     */
    public function paginator(): PaginatorInterface|null;

    /**
     * @return static<T>
     *
     * @phpstan-ignore-next-line
     */
    public function withPagination(int $page, int $itemsPerPage): static;
}
