<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Address{

    /**
     * @MongoDB\Field
     */
    protected $line;
    
    /**
     * @MongoDB\Field
     */
    protected $line2;
    
    /**
     * @MongoDB\Field
     */
    protected $line3;
    
    /**
     * @MongoDB\Field
     */
    protected $city;  

    /**
     * Get the value of line
     */ 
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set the value of line
     *
     * @return  self
     */ 
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get the value of line2
     */ 
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * Set the value of line2
     *
     * @return  self
     */ 
    public function setLine2($line2)
    {
        $this->line2 = $line2;

        return $this;
    }

    /**
     * Get the value of line3
     */ 
    public function getLine3()
    {
        return $this->line3;
    }

    /**
     * Set the value of line3
     *
     * @return  self
     */ 
    public function setLine3($line3)
    {
        $this->line3 = $line3;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }
}