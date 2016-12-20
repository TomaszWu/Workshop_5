<?php

namespace Workshop5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Workshop5Bundle\Repository\AddressRepository")
 */
class Address {

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="addresses")
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
     * @var string
     * @Assert\Length(min=5,
     * minMessage = "Długość imienia to minimum 5 znaków."
     * )
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     * @Assert\Length(min=2,
     * minMessage = "Długość imienia to minimum 5 znaków."
     * )
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="flat_number", type="integer")
     */
    private $flatNumber;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="house_number", type="integer")
     */
    private $houseNumber;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Set flatNumber
     *
     * @param integer $flatNumber
     * @return Address
     */
    public function setFlatNumber($flatNumber) {
        $this->flatNumber = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return integer 
     */
    public function getFlatNumber() {
        return $this->flatNumber;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return integer 
     */
    public function getHouseNumber() {
        return $this->houseNumber;
    }

    /**
     * Set person
     *
     * @param \Workshop5Bundle\Entity\Person $person
     * @return Address
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

}
