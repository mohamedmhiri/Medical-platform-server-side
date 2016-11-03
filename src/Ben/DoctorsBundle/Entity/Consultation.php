<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\ConsultationRepository")
 */
class Consultation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // public static $GENERAL  = 'Consultation generale';
    // public static $SPECIAL  = 'Consultation spécialisé';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="motiftype", type="string", length=255, nullable=true)
     */
    private $motiftype;





    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

   /**
     * @var string
     *
     * @ORM\Column(name="diagnosis", type="text", nullable=true)
     */
    private $diagnosis;

   /**
     * @var string
     *
     * @ORM\Column(name="treatment", type="text", nullable=true)
     */
    private $treatment;
    /**
     * @var string
     *
     * @ORM\Column(name="anamnese", type="text", nullable=true)
     */
    private $anamnese;


    /**
     * @var string
     *
     * @ORM\Column(name="decision", type="text", nullable=true)
     */
    private $decision;


    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Person", inversedBy="consultations", cascade={"remove", "persist"})
    * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
    */
    private $person;

    /**
    * @ORM\ManyToOne(targetEntity="Ben\UserBundle\Entity\User", inversedBy="consultations", cascade={"all"})
    * @ORM\JoinColumn(name="doc_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\Test", mappedBy="consultation", cascade={"all"})
    */
    protected $tests;




    /************ constructeur ************/

    public function __construct()
    {
        $this->created = new \DateTime;
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->image= new \Ben\DoctorsBundle\Entity\image();
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
     * Set id
     *
     * @param string $id
     * @return Consultation
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Consultation
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
     * Set created
     *
     * @param \DateTime $created
     * @return Consultation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set person
     *
     * @param \Ben\DoctorsBundle\Entity\Person $person
     * @return Consultation
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
     * Set user
     *
     * @param \Ben\UserBundle\Entity\User $user
     * @return Consultation
     */
    public function setUser(\Ben\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Ben\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add tests
     *
     * @param \Ben\DoctorsBundle\Entity\Test $tests
     * @return Consultation
     */
    public function addTest(\Ben\DoctorsBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests
     *
     * @param \Ben\DoctorsBundle\Entity\Test $tests
     */
    public function removeTest(\Ben\DoctorsBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTests()
    {
        return $this->tests;
    }




    /**
     * Get diagnosis
     *
     * @return string
     */
    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * Set treatment
     *
     * @param string $treatment
     * @return Consultation
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;

        return $this;
    }

    /**
     * Get treatment
     *
     * @return string
     */
    public function getTreatment()
    {
        return $this->treatment;
    }


    /**
     * Set motiftype
     *
     * @param string $motiftype
     * @return Consultation
     */
    public function setMotiftype($motiftype)
    {
        $this->motiftype = $motiftype;

        return $this;
    }

    /**
     * Get motiftype
     *
     * @return string
     */
    public function getMotiftype()
    {
        return $this->motiftype;
    }
    /**
     * Set anamnese
     *
     * @param string $anamnese
     * @return Consultation
     */
    public function setAnamnese($anamnese)
    {
        $this->anamnese = $anamnese;

        return $this;
    }

    /**
     * Get anamnese
     *
     * @return string
     */
    public function getAnamnese()
    {
        return $this->anamnese;
    }

    /**
     * Set decision
     *
     * @param string $decision
     * @return Consultation
     */
    public function setDecision($decision)
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * Get decision
     *
     * @return string
     */
    public function getDecision()
    {
        return $this->decision;
    }
    
}
