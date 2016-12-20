<?php

namespace Workshop5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Telephone
 *
 * @ORM\Table(name="telephone")
 * @ORM\Entity(repositoryClass="Workshop5Bundle\Repository\TelephoneRepository")
 */
class Telephone {

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="emails")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $person;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @Assert\Length(min=5,
     * minMessage = "Długość nr to minimum 7 znaków."
     * )
     * @ORM\Column(name="telephone_number", type="integer")
     */
    private $telephoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set telephoneNumber
     *
     * @param integer $telephoneNumber
     * @return Telephone
     */
    public function setTelephoneNumber($telephoneNumber) {
        $this->telephoneNumber = $telephoneNumber;

        return $this;
    }

    /**
     * Get telephoneNumber
     *
     * @return integer 
     */
    public function getTelephoneNumber() {
        return $this->telephoneNumber;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Telephone
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set person
     *
     * @param \Workshop5Bundle\Entity\Person $person
     * @return Telephone
     */
    public function setPerson(\Workshop5Bundle\Entity\Person $person = null) {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Workshop5Bundle\Entity\Person 
     */
    public function getPerson() {
        return $this->person;
    }
    
     public function __toString() {
        return $this->type;
    }

}
