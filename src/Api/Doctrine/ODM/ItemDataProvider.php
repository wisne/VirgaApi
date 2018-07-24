<?php

namespace App\Api\Doctrine\ODM;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Serializer\SerializerInterface;


final class ItemDataProvider implements ItemDataProviderInterface,RestrictedDataProviderInterface
{
    private $manager;
    private $serializer;

    public function __construct(DocumentManager $manager, SerializerInterface $serializer)
    {
        $this->manager = $manager;
        $this->serializer = $serializer;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return null != $this->manager->getRepository($resourceClass);
    }

    public function getItem(string $resourceClass, $identifiers, string $operationName = null, array $context = [])
    {    
        $prod = $this->manager->getRepository($resourceClass)->find($identifiers);
        $result  = $this->serializer->serialize($prod,'json');
        
        return json_decode($result,true);
    }
}
