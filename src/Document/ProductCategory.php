<?php

namespace App\Document;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ODM\MongoDB\Mapping\Annotations\UniqueIndex;

/**
 * @MongoDB\Document(collection="product_categories")
 * @ApiResource
 */
class ProductCategory
{

    /**
     * @MongoDB\Id
     */
    protected $id;


    /**
     * @MongoDB\Field(type="int")
     * @UniqueIndex
     */
    protected $categoryId;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\ReferenceOne(targetDocument="ProductCategory")
     */
    protected $parent;

    /**
     * @MongoDB\ReferenceMany(targetDocument="ProductCategory",mappedBy="parent")
     */
    protected $children;


    /**
     * @MongoDB\ReferenceMany(targetDocument="Product",mappedBy="categories")
     */
    protected $products;
    


    /**
     * Get the value of categoryId
     */ 
    public function getCategoryId() : int
    {
        return $this->categoryId;
    }

    /**
     * Set the value of categoryId
     *
     * @return  self
     */ 
    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
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
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    

    /**
     * Get the value of parent
     */ 
    public function getParent() : ?ProductCategory
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @return  self
     */ 
    public function setParent(?ProductCategory $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the value of children
     */ 
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the value of children
     *
     * @return  self
     */ 
    public function addChildren(ProductCategory $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Get the value of products
     */ 
    public function getProducts()
    {
        return $this->products;
    }

    
}
