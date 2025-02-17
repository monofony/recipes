<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Security\Infrastructure\Security\User\Canonicalizer;

final class Canonicalizer implements CanonicalizerInterface
{
    #[\Override]
    public function canonicalize(string|null $string): string|null
    {
        return null === $string ? null : mb_convert_case($string, \MB_CASE_LOWER, mb_detect_encoding($string) ?: null);
    }
}
