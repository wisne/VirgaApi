<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields={"email","phone"})
 */

 class User implements UserInterface
 {
     /**
      * @MongoDB\Id
      */
     protected $id;

     /**
      * @MongoDB\Field(type="string")
     
      */
     protected $email;

     /**
     * @MongoDB\Field(type="string")
  
     */
     protected $phone;
      
     /**
      * @MongoDB\Field(type="string")
    
      */
     protected $password;

     /**
      * @MongoDB\Field(type="boolean")
      */
    protected $isActive;


    /**
     * @MongoDB\Field(type="int")
     */
    protected $roles; 

    /**
     * @MongoDB\Field(type="date")
     */
    protected $registrationDate;


    /**
     * @MongoDB\ReferenceMany(targetDocument="product", mappedBy="seller")
     */
    protected $products;

    
    /**
     * @MongoDB\EmbedMany(targetDocument="Address")
     */

     protected $addresses;

    
    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));

        $this->addresses = array();
    }

    /**
     * Get the value for username
     */
    public function getUsername()
    {
        $this->phone;
    }

    /**
     * set the username 
     */
    public function setUsername($username)
    {
        $this->phone = $username;
    }

    


     /**
      * Get the value of email
      */ 
     public function getEmail()
     {
          return $this->email;
     }

     /**
      * Set the value of email
      *
      * @return  self
      */ 
     public function setEmail($email)
     {
          $this->email = $email;

          return $this;
     }

     /**
      * Get the value of password
      */ 
     public function getPassword()
     {
          return $this->password;
     }

     /**
      * Set the value of password
      *
      * @return  self
      */ 
     public function setPassword($password)
     {
          $this->password = $password;

          return $this;
     }

     /**
      * Get the value of phone
      */ 
     public function getPhone()
     {
          return $this->phone;
     }

     /**
      * Set the value of phone
      *
      * @return  self
      */ 
     public function setPhone($phone)
     {
          $this->phone = $phone;

          return $this;
     }

     
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * Get the value of role
     */ 
    public function getRoles()
    {
        if($this->roles == 0){
            return array('ROLE_USER');
        }
        if( $this->roles == 1){
            return array('ROLE_RETAILER');
        }
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }
    
    /**
     * Get salt
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

   
    /**
     * Get the value of registrationDate
     */ 
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set the value of registrationDate
     *
     * @return  self
     */ 
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

     /**
      * Get the value of addresses
      */ 
     public function getAddresses()
     {
          return $this->addresses;
     }

     /**
      * Set the value of addresses
      *
      * @return  self
      */ 
     public function addAddresses(?Address $addresses)
     {
          $this->addresses[] = $addresses;

          return $this;
     }
 }
