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
 * Availability
 *
 * @ORM\Table(name="availabilities")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\AvailabilityRepository")
 */

class Availability
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
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;
    /**
     * @ORM\ManyToOne(targetEntity="Ben\UserBundle\Entity\User", inversedBy="availabilities")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /************ constructeur ************/

    public function __construct()
    {
        $this->date = new \DateTime;
    }

    /************ getters & setters  ************/
    /**
     * Set id
     *
     * @param integer $id
     * @return Availability
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * Set start
     *
     * @param \DateTime $start
     * @return Availability
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }
    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Availability
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set person
     *
     * @param \Ben\UserBundle\Entity\User $user
     * @return Availability
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

}