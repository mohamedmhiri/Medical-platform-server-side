<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 2016/09/14
 * Time: 5:50 PM
 */

namespace Ben\DoctorsBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Appointment
 *
 * @ORM\Table(name="appointments")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\AppointmentRepository")
 */

class Appointment
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Person", inversedBy="appointments")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
     */
    private $person;

    /************ constructeur ************/

    public function __construct()
    {
        $this->date = new \DateTime;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Appointment
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
     * Set person
     *
     * @param \Ben\DoctorsBundle\Entity\Person $person
     * @return Appointment
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

}