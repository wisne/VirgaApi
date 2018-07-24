<?php
namespace App\Api\Doctrine\ODM;

use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use App\Document\Product;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use App\Api\Doctrine\ODM\Extension\QueryResultCollectionExtensionInterface;

/**
 * Collection data provider for the Doctrine MongoDB ODM.
 */
class CollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $managerRegistry;
    private $collectionExtensions;
    private $serializer;

    public function __construct(DocumentManager $managerRegistry, SerializerInterface $serializer, $collectionExtensions = [])
    {
        $this->managerRegistry = $managerRegistry;

        $this->serializer = $serializer;

        $this->collectionExtensions = $collectionExtensions;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $this->managerRegistry->getRepository($resourceClass) != null;
    }


    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null,array $context = [])
    {
        $manager = $this->managerRegistry;

        $repository =  $manager->getRepository($resourceClass);

        if (!method_exists($repository, 'createQueryBuilder')) {
            throw new RuntimeException('The repository class must have a "createQueryBuilder" method.');
        }

        $queryBuilder = $repository->createQueryBuilder('o');

        $queryNameGenerator = new QueryNameGenerator();
       

        foreach ($this->collectionExtensions as $extension) {
           
            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);
            
            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context)) {
              
                $query = $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);

                $results = $query->execute()->toArray();

                $data = $this->serializer->serialize($results, 'json', SerializationContext::create()->enableMaxDepthChecks());
     
                return json_decode($data, true);
            }
        }
        

        $query = $queryBuilder->getQuery()->execute()->toArray();

        $data = $this->serializer->serialize($query, 'json', SerializationContext::create()->enableMaxDepthChecks());
     
        return json_decode($data, true);
    }
}
