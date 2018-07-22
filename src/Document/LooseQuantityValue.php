<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ORM\Mapping\DiscriminatorMap;


/**
 * @MongoDB\EmbeddedDocument
 */
class LooseQuantityValue 
{
    /**
     *  @MongoDB\Field(type="float") 
     * 
     */
    protected $value;

    /**
     * @MongoDB\Field(type="float") 
     * 
     */
    protected $price;

    /**
     * @MongoDB\Field(type="float")
     * 
     */
    protected $offerPrice;

    /**
     * @MongoDB\Field(type="hash")
     */
    protected $attributes = array();

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of attributes
     */ 
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @return  self
     */ 
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

   

    /**
     * Get the value of offerPrice
     */ 
    public function getOfferPrice()
    {
        return $this->offerPrice;
    }

    /**
     * Set the value of offerPrice
     *
     * @return  self
     */ 
    public function setOfferPrice($offerPrice)
    {
        $this->offerPrice = $offerPrice;

        return $this;
    }
}