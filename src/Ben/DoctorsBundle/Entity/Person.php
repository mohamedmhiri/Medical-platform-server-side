<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="cin", type="string", length=255)
     */
    private $cin;



    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="familyname", type="string", length=255)
     */
    private $familyname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="oldemail", type="string", length=255, nullable=true)
//     */
//    private $oldemail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="birthcity", type="string", length=255, nullable=true)
     */
    private $birthcity;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="contry", type="string", length=255, nullable=true)
     */
    private $contry;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;



    /**
     * @var string
     *
     * @ORM\Column(name="gsm", type="string", length=255, nullable=true)
     */
    private $gsm;


    /**
     * @var integer
     *
     *
     */
    private $nb_tests;


    /**
     * @var string
     *
     * @ORM\Column(name="cnsstype", type="string", length=255)
     */
    private $cnsstype;
    /**
     * @var string
     *
     * @ORM\Column(name="cnssnum", type="string", length=255)
     */
    private $cnssnum;



    /**
     * @var string
     *
     * @ORM\Column(name="parent_gsm", type="string", length=255, nullable=true)
     */
    private $parentGsm;

//    /**
//    *@var boolean
//    *
//    *@ORM\Column(name="isnp", type="boolean")
//    */
//    private $isnp;
    /**
     * @var \DateTime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\Antecedent", mappedBy="person", cascade={"remove", "persist"})
    */
    protected $antecedents;
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="npid", type="integer")
//     */
//    private $npid;

    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\Consultation", mappedBy="person", cascade={"all"})
    */
    protected $consultations;



    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\Appointment", mappedBy="person", cascade={"all"})
     */
    protected $appointments;
    /**
     *@var boolean
     *
     *@ORM\Column(name="isDeleted", type="boolean")
     */
    private $isDeleted;



    /************ constructeur ************/

    public function __construct()
    {
        $this->birthday =  new \DateTime;
        $this->created = new \DateTime;
        $this->antecedents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consultations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->appointments = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /************ getters & setters  ************/
    /**
    * Set id
    *
    * @param integer $id
    * @return Person
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

//    /**
//    * Set npid
//    *
//    * @param integer $npid
//    * @return Person
//    */
//    public function setNpid($npid)
//    {
//      $this->npid=$npid;
//      return $this;
//    }
//   /**
//     * Get npid
//     *
//     * @return integer
//     */
//    public function getNpid()
//    {
//        return $this->npid;
//    }

    /**
     * Get FullName
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName();
    }

    /**
     * Set cin
     *
     * @param string $cin
     * @return Person
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }



    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set familyname
     *
     * @param string $familyname
     * @return Person
     */
    public function setFamilyname($familyname)
    {
        $this->familyname = $familyname;

        return $this;
    }

    /**
     * Get familyname
     *
     * @return string
     */
    public function getFamilyname()
    {
        return $this->familyname;
    }

    /**
     * Get FullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->familyname.' '.$this->firstname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
//    /**
//     * Set oldemail
//     *
//     * @param string $oldemail
//     * @return Person
//     */
//    public function setOldemail($oldemail)
//    {
//        $this->oldemail = $oldemail;
//
//        return $this;
//    }
//
//    /**
//     * Get oldemail
//     *
//     * @return string
//     */
//    public function getOldemail()
//    {
//        return $this->oldemail;
//    }
    /**
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @return Person
     * @param boolean $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Person
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set birthcity
     *
     * @param string $birthcity
     * @return Person
     */
    public function setBirthcity($birthcity)
    {
        $this->birthcity = $birthcity;

        return $this;
    }

    /**
     * Get birthcity
     *
     * @return string
     */
    public function getBirthcity()
    {
        return $this->birthcity;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set contry
     *
     * @param string $contry
     * @return Person
     */
    public function setContry($contry)
    {
        $this->contry = $contry;

        return $this;
    }

    /**
     * Get contry
     *
     * @return string
     */
    public function getContry()
    {
        return $this->contry;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Person
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Person
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }



    /**
     * Set gsm
     *
     * @param string $gsm
     * @return Person
     */
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;

        return $this;
    }

    /**
     * Get gsm
     *
     * @return string
     */
    public function getGsm()
    {
        return $this->gsm;
    }



    /**
     * Set cnsstype
     *
     * @param string $cnsstype
     * @return Person
     */
    public function setCnsstype($cnsstype)
    {
        $this->cnsstype = $cnsstype;

        return $this;
    }

    /**
     * Get cnsstype
     *
     * @return string
     */
    public function getCnsstype()
    {
        return $this->cnsstype;
    }
    /**
     * Set cnssnum
     *
     * @param string $cnssnum
     * @return Person
     */
    public function setCnssnum($cnssnum)
    {
        $this->cnssnum = $cnssnum;

        return $this;
    }

    /**
     * Get cnssnum
     *
     * @return string
     */
    public function getCnssnum()
    {
        return $this->cnssnum;
    }
    /**
     * Set parentGsm
     *
     * @param string $parentGsm
     * @return Person
     */
    public function setParentGsm($parentGsm)
    {
        $this->parentGsm = $parentGsm;

        return $this;
    }

    /**
     * Get parentGsm
     *
     * @return string
     */
    public function getParentGsm()
    {
        return $this->parentGsm;
    }

    /**
     * Get nb_tests
     *
     * @return Person
     */
    public function getNb_Tests()
    {
        foreach ($this->consultations as $consultation)
            foreach ($consultation->getTests() as $test)
                $this->nb_tests ++;
        return $this->nb_tests;
    }

    /**
     *
     * Set nb_tests
     *
     * @param integer $nb_tests
     */
    public function setNb_Tests($nb_tests)
    {
        $this->nb_tests = $nb_tests;
    }

//  /**
//     * Set isnp
//     *
//     * @param boolean $isnp
//     * @return Person
//     */
//    public function setISNP($isnp)
//    {
//        $this->isnp = $isnp;
//
//        return $this;
//    }
//
//    /**
//     * Get isnp
//     *
//     * @return boolean
//     */
//    public function getISNP()
//    {
//        return $this->isnp;
//    }


    /**
     * Add antecedents
     *
     * @param \Ben\DoctorsBundle\Entity\Antecedent $antecedents
     * @return Person
     */
    public function addAntecedent(\Ben\DoctorsBundle\Entity\Antecedent $antecedents)
    {
        $this->antecedents[] = $antecedents;

        return $this;
    }

    /**
     * Remove antecedents
     *
     * @param \Ben\DoctorsBundle\Entity\Antecedent $antecedents
     */
    public function removeAntecedent(\Ben\DoctorsBundle\Entity\Antecedent $antecedents)
    {
        $this->antecedents->removeElement($antecedents);
    }

    /**
     * Get antecedents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAntecedents()
    {
        return $this->antecedents;
    }
    /**
     * Add appointments
     *
     * @param \Ben\DoctorsBundle\Entity\Appointment $appointments
     * @return Person
     */
    public function addAppointment(\Ben\DoctorsBundle\Entity\Appointment $appointments)
    {
        $this->appointments[] = $appointments;

        return $this;
    }

    /**
     * Remove appointments
     *
     * @param \Ben\DoctorsBundle\Entity\Antecedent $appointment
     */
    public function removeAppointment(\Ben\DoctorsBundle\Entity\Appointment $appointments)
    {
        $this->appointments->removeElement($appointments);
    }

    /**
     * Get appointments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppointments()
    {
        return $this->appointments;
    }
     /**
     * Add consultations
     *
     * @param \Ben\DoctorsBundle\Entity\Consultation $consultations
     * @return Person
     */
    public function addConsultation(\Ben\DoctorsBundle\Entity\Consultation $consultations)
    {
        $this->consultations[] = $consultations;

        return $this;
    }
    /**
     * set consultation
     *
     * @param \Ben\DoctorsBundle\Entity\Consultation $consultations
     * @return Person
     */
    public function setConsultation(\Ben\DoctorsBundle\Entity\Consultation $consultation)
    {

        foreach ($this->consultations as $cons)
            if($cons->getId() == $consultation->getId())
                $cons=$consultation;

        return $this;
    }

    /**
     * Remove consultations
     *
     * @param \Ben\DoctorsBundle\Entity\Consultation $consultations
     */
    public function removeConsultation(\Ben\DoctorsBundle\Entity\Consultation $consultations)
    {
        $this->consultations->removeElement($consultations);
    }

    /**
     * Get consultations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConsultations()
    {
        return $this->consultations;
    }
    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Person
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }
}
