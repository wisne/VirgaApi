<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ORM\Mapping\DiscriminatorMap;


/**
 * @MongoDB\EmbeddedDocument
 */
class LooseQuantity extends ProductQuantity{

    /**
     * @MongoDB\Field
     */
    protected $unitName;


    /**
     * @MongoDB\Field(type="float")
     */
    protected $minimum;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $maximum;

    
     /**
     * @MongoDB\EmbedMany
     */
    protected $values = array();

    
     /**
     * Get the value of unitName
     */ 
    public function getUnitName()
    {
        return $this->unitName;
    }

    /**
     * Set the value of unitName
     *
     * @return  self
     */ 
    public function setUnitName($unitName)
    {
        $this->unitName = $unitName;

        return $this;
    }


    /**
     * Get the value of values
     */ 
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Set the value of values
     *
     * @return  self
     */ 
    public function addValues($value)
    {
        $this->values[] = $value;

        return $this;
    }


    /**
     * Get the value of minimum
     */ 
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * Set the value of minimum
     *
     * @return  self
     */ 
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * Get the value of maximum
     */ 
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * Set the value of maximum
     *
     * @return  self
     */ 
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }
}


