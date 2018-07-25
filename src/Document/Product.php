<?php

namespace App\Document;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Type;


/**
 * @MongoDB\Document(collection="products")
 * @ApiResource
 */
class Product 
{
    /**
     * @MongoDB\Id
     * @ApiProperty(identifier=true)
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * 
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     * 
     */
    protected $description;

    /**
     * @MongoDB\Field(type="string")
     *  
     */
    protected $imageUrl;

    /**
     * @MongoDB\ReferenceMany(targetDocument="ProductCategory", inversedBy="products")
     * 
     */
    protected $categories = array();


    /**
     * @MongoDB\EmbedOne(discriminatorField="type",discriminatorMap={
     *     "loose_quantity"="App\Document\LooseQuantity"
     *     
     *   })
     */
    protected $quantity;


    /**
     * @MongoDB\ReferenceOne(targetDocument="User", inversedBy="products")
     * @MaxDepth(1)
     */
    protected $seller;


    /**
     * @MongoDB\Field("string")
     * 
     */
    protected $keywords;

    
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of imageUrl
     */ 
    public function getImageUrl() : ?string
    {
        return $this->imageUrl;
    }

    /**
     * Set the value of imageUrl
     *
     * @return  self
     */ 
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get the value of categories
     * @return ProductCategory[]
     */ 
    public function getCategories() 
    {
        return $this->categories;
    }

    /**
     * Set Categories
     * 
     * @return self
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */ 
    public function addCategories(array $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity) 
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of seller
     */ 
    public function getSeller() : User
    {
        return $this->seller;
    }

    /**
     * Set the value of seller
     *
     * @return  self
     */ 
    public function setSeller(User $seller)
    {
        $this->seller = $seller;

        return $this;
    }

   

}
