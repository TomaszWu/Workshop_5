<?php

namespace Workshop5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="Workshop5Bundle\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="person")
     */
    private $addresses;
    /**
     * @ORM\OneToMany(targetEntity="Telephone", mappedBy="person")
     */
    private $telephones;
    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="person")
     */
    private $mailes;
    
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


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
     * @return Person
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
     * Set surname
     *
     * @param string $surname
     * @return Person
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Person
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->telephones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mailes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add addresses
     *
     * @param \Workshop5Bundle\Entity\Address $addresses
     * @return Person
     */
    public function addAddress(\Workshop5Bundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \Workshop5Bundle\Entity\Address $addresses
     */
    public function removeAddress(\Workshop5Bundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add telephones
     *
     * @param \Workshop5Bundle\Entity\Telephone $telephones
     * @return Person
     */
    public function addTelephone(\Workshop5Bundle\Entity\Telephone $telephones)
    {
        $this->telephones[] = $telephones;

        return $this;
    }

    /**
     * Remove telephones
     *
     * @param \Workshop5Bundle\Entity\Telephone $telephones
     */
    public function removeTelephone(\Workshop5Bundle\Entity\Telephone $telephones)
    {
        $this->telephones->removeElement($telephones);
    }

    /**
     * Get telephones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTelephones()
    {
        return $this->telephones;
    }

    /**
     * Add mailes
     *
     * @param \Workshop5Bundle\Entity\Email $mailes
     * @return Person
     */
    public function addMaile(\Workshop5Bundle\Entity\Email $mailes)
    {
        $this->mailes[] = $mailes;

        return $this;
    }

    /**
     * Remove mailes
     *
     * @param \Workshop5Bundle\Entity\Email $mailes
     */
    public function removeMaile(\Workshop5Bundle\Entity\Email $mailes)
    {
        $this->mailes->removeElement($mailes);
    }

    /**
     * Get mailes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMailes()
    {
        return $this->mailes;
    }
}
