<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Api\Doctrine\ODM\Extension;

use Doctrine\ODM\MongoDB\Query\Builder;


/**
 * Context aware extension.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface ContextAwareQueryItemExtensionInterface extends QueryItemExtensionInterface
{
    public function supportsResult(string $resourceClass, string $operationName = null, array $context = []): bool;

    /**
     * @return mixed
     */
    public function getResult(Builder $queryBuilder, string $resourceClass = null, string $operationName = null, array $context = []);
}
