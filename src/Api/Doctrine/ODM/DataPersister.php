<?php

namespace App\Api\Doctrine\ODM;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use ApiPlatform\Core\Util\ClassInfoTrait;



class DataPersister implements DataPersisterInterface{
    
    private $manager;

    use ClassInfoTrait;

    public function __construct(DocumentManager $manager)
    {
        $this->manager = $manager;    
    }
    
    public function supports($data) : bool
    {
        return null !== $this->getManager($data);
    }

    public function persist($data)
    {
        if (!$manager = $this->getManager($data)) {
            return $data;
        }

        if (!$manager->contains($data)) {
            $manager->persist($data);
        }

        $manager->flush();
        $manager->refresh($data);

        return $data;
    }

    public function remove($data)
    {
        if (!$manager = $this->getManager($data)) {
            return;
        }

        $manager->remove($data);
        $manager->flush();
    }

    /**
     * Gets the Doctrine object manager associated with given data.
     *
     * @param mixed $data
     *
     * @return DoctrineObjectManager|null
     */
    private function getManager($data)
    {
        return \is_object($data) ? $this->manager : null;
    }

}