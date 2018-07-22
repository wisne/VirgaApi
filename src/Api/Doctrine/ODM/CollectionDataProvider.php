<?php
namespace App\Api\Doctrine\ODM;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\Exception\RuntimeException;
use App\Document\Product;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use Doctrine\ODM\MongoDB\DocumentManager;


/**
 * Collection data provider for the Doctrine MongoDB ODM.
 */
class CollectionDataProvider implements CollectionDataProviderInterface
{
    private $managerRegistry;
    private $collectionExtensions;
   
    /**
     * @param ManagerRegistry                      $managerRegistry
     * @param QueryCollectionExtensionInterface[]  $collectionExtensions
     * @param CollectionDataProviderInterface|null $decorated
     */
    public function __construct(DocumentManager $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
      
        
    }
    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
       $manager = $this->managerRegistry;

        $query = $manager->getRepository($resourceClass)->createQueryBuilder()->hydrate(false)->getQuery()->getSingleResult();
     
        return $query;
    }
}