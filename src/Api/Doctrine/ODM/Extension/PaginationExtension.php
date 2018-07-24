<?php


declare(strict_types=1);

namespace App\Api\Doctrine\ODM\Extension;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Metadata\Resource\ResourceMetadata;

class PaginationExtension implements ContextAwareQueryResultCollectionExtensionInterface
{
    private $managerRegistry;
    private $requestStack;
    private $resourceMetadataFactory;
    private $enabled;
    private $clientEnabled;
    private $clientItemsPerPage;
    private $itemsPerPage;
    private $pageParameterName;
    private $enabledParameterName;
    private $itemsPerPageParameterName;
    private $maximumItemPerPage;
    private $partial;
    private $clientPartial;
    private $partialParameterName;

    public function __construct(DocumentManager $managerRegistry, RequestStack $requestStack, ResourceMetadataFactoryInterface $resourceMetadataFactory, bool $enabled = true, bool $clientEnabled = false, bool $clientItemsPerPage = false, int $itemsPerPage = 30, string $pageParameterName = 'page', string $enabledParameterName = 'pagination', string $itemsPerPageParameterName = 'itemsPerPage', int $maximumItemPerPage = null, bool $partial = false, bool $clientPartial = false, string $partialParameterName = 'partial')
    {
        $this->managerRegistry = $managerRegistry;
        $this->requestStack = $requestStack;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->enabled = $enabled;
        $this->clientEnabled = $clientEnabled;
        $this->clientItemsPerPage = $clientItemsPerPage;
        $this->itemsPerPage = $itemsPerPage;
        $this->pageParameterName = $pageParameterName;
        $this->enabledParameterName = $enabledParameterName;
        $this->itemsPerPageParameterName = $itemsPerPageParameterName;
        $this->maximumItemPerPage = $maximumItemPerPage;
        $this->partial = $partial;
        $this->clientPartial = $clientPartial;
        $this->partialParameterName = $partialParameterName;
    }

    public function applyToCollection(Builder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (null === $resourceClass) {
            throw new InvalidArgumentException('The "$resourceClass" parameter must not be null');
        }

        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return;
        }

        $resourceMetadata = $this->resourceMetadataFactory->create($resourceClass);
        if (!$this->isPaginationEnabled($request, $resourceMetadata, $operationName)) {
            return;
        }

        $itemsPerPage = $resourceMetadata->getCollectionOperationAttribute($operationName, 'pagination_items_per_page', $this->itemsPerPage, true);
        if ($request->attributes->get('_graphql')) {
            $collectionArgs = $request->attributes->get('_graphql_collections_args', []);
            $itemsPerPage = $collectionArgs[$resourceClass]['first'] ?? $itemsPerPage;
        }
        
        if ($resourceMetadata->getCollectionOperationAttribute($operationName, 'pagination_client_items_per_page', $this->clientItemsPerPage, true)) {
            $maxItemsPerPage = $resourceMetadata->getCollectionOperationAttribute($operationName, 'maximum_items_per_page', $this->maximumItemPerPage, true);

            $itemsPerPage = (int) $this->getPaginationParameter($request, $this->itemsPerPageParameterName, $itemsPerPage);
            $itemsPerPage = (null !== $maxItemsPerPage && $itemsPerPage >= $maxItemsPerPage ? $maxItemsPerPage : $itemsPerPage);
        }

        
        if (0 > $itemsPerPage) {
            throw new InvalidArgumentException('Item per page parameter should not be less than 0');
        }

        $page = (int) $this->getPaginationParameter($request, $this->pageParameterName, 1);

        if (1 > $page) {
            throw new InvalidArgumentException('Page should not be less than 1');
        }

        if (0 === $itemsPerPage && 1 < $page) {
            throw new InvalidArgumentException('Page should not be greater than 1 if itemsPerPage is equal to 0');
        }

        $firstResult = ($page - 1) * $itemsPerPage;
        if ($request->attributes->get('_graphql')) {
            $collectionArgs = $request->attributes->get('_graphql_collections_args', []);
            if (isset($collectionArgs[$resourceClass]['after'])) {
                $after = \base64_decode($collectionArgs[$resourceClass]['after'], true);
                $firstResult = (int) $after;
                $firstResult = false === $after ? $firstResult : ++$firstResult;
            }
        }
        
        $queryBuilder
            ->skip($firstResult)
            ->limit($itemsPerPage);
    }

    public function supportsResult(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return false;
        }
        $resourceMetadata = $this->resourceMetadataFactory->create($resourceClass);

        return $this->isPaginationEnabled($request, $resourceMetadata, $operationName);
    }

    /**
     * @return mixed
     */
    public function getResult(Builder $queryBuilder, string $resourceClass = null, string $operationName = null, array $context = [])
    {
        return $queryBuilder->getQuery();
    }



    private function isPaginationEnabled(Request $request, ResourceMetadata $resourceMetadata, string $operationName = null): bool
    {
        $enabled = $resourceMetadata->getCollectionOperationAttribute($operationName, 'pagination_enabled', $this->enabled, true);
        $clientEnabled = $resourceMetadata->getCollectionOperationAttribute($operationName, 'pagination_client_enabled', $this->clientEnabled, true);

        if ($clientEnabled) {
            $enabled = filter_var($this->getPaginationParameter($request, $this->enabledParameterName, $enabled), FILTER_VALIDATE_BOOLEAN);
        }

        return $enabled;
    }

    private function getPaginationParameter(Request $request, string $parameterName, $default = null)
    {
        if (null !== $paginationAttribute = $request->attributes->get('_api_pagination')) {
            return array_key_exists($parameterName, $paginationAttribute) ? $paginationAttribute[$parameterName] : $default;
        }

        return $request->query->get($parameterName, $default);
    }
}
