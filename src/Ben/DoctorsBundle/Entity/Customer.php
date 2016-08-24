<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Carbon\Carbon;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Person
 *
 * @ORM\Entity()
 * @ORM\Table(name="customer")
 */
class Customer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
    * @var datetime
    * @ORM\Column(name="validuntil", type="datetime")
    */
    private $validUntil;
    /**
     * @var boolean
     * @ORM\Column(name="isvalid", type="boolean", nullable=true)
     *
     */
    private $isValid;


    /************ constructeur ************/

    public function __construct()
    {

        $this->password = openssl_random_pseudo_bytes(60);
        $time=new Carbon();
        $time->minute += 2;
        $this->validUntil = $time;
        $this->isValid=1;
    }

    /************ getters & setters  ************/
    /**
    * Set id
    *
    * @param integer $id
    * @return Customer
    */
    public function setId($id)
    {
      $this->id=$id;
      return $this;
    }
   /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set name
     *
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
    *
    * Set isValid
    *
    * @param string $isValid
    * @return Customer
    *
    */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
    *
    *Get isValid
    *
    * @return DateTime
    */
    public function getIsValid()
    {
        return $this->isValid;
    }
    /**
    *
    *Get passwd
    *
    * @return string
    */
    public function getPassword()
    {
        return $this->password;
    }
    /**
    *
    *Get validUntil
    *
    * @return datetime
    */
    public function getValidUntil()
    {
      return $this->validUntil;
    }

}
