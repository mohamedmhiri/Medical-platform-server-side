<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\TestRepository")
 */
class Test
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // public static $GENERAL  = 'Examen Générale';



    /**
     * @var string
     *
     * @ORM\Column(name="typeexam", type="string", length=255, nullable=true)
     */
    private $typeexam;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\image", mappedBy="test",cascade={"remove", "persist"})
    */
    private $images;

    /**
     * @var string
     *
     *@ORM\Column(name="conclusion", type="text", nullable=true)
     */
    private $conclusion;



    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Person", inversedBy="tests", cascade={"all"})
    * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
    */
    private $person;
    /**
    *@var boolean
    *
    *@ORM\Column(name="isDeleted", type="boolean")
    */
    private $isDeleted;

    /**
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @return Test
     * @param boolean $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }


    /************ constructeur ************/

    public function __construct()
    {
      $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /************ getters & setters  ************/

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
     * Set person
     *
     * @param \Ben\DoctorsBundle\Entity\Person $person
     * @return Test
     */
    public function setPerson(\Ben\DoctorsBundle\Entity\Person $person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Ben\DoctorsBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set typeexam
     *
     * @param string $taille
     * @return Test
     */
    public function setTypeexam($typeexam)
    {
        $this->typeexam = $typeexam;

        return $this;
    }

    /**
     * Get typeexam
     *
     * @return string
     */
    public function getTypeexam()
    {
        return $this->typeexam;
    }

    /**
     * Set conclusion
     *
     * @param string $conclusion
     * @return Test
     */
    public function setConclusion($conclusion)
    {
        $this->conclusion = $conclusion;

        return $this;
    }

    /**
     * Get conclusion
     *
     * @return string
     */
    public function getConclusion()
    {
        return $this->conclusion;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Test
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set lieu
     *
     * @param string $lieu
     * @return Test
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }
    // /**
    //  * Set images
    //  *
    //  * @param \Ben\DoctorsBundle\Entity\images $images
    //  * @return profile
    //  */
    // public function setImages(\Ben\DoctorsBundle\Entity\image $images = null)
    // {
    //     $this->images = $images;
    //
    //     return $this;
    // }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
    /**
     * Add images
     *
     * @param \Ben\DoctorsBundle\Entity\image $images
     * @return Test
     */
    public function addImage(\Ben\DoctorsBundle\Entity\image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Ben\DoctorsBundle\Entity\image $images
     */
    public function removeImage(\Ben\DoctorsBundle\Entity\image $images)
    {
        $this->images->removeElement($images);
    }


}
