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

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * Context aware extension.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface ContextAwareQueryCollectionExtensionInterface extends QueryCollectionExtensionInterface
{
    public function applyToCollection(Builder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null, array $context = []);
}
